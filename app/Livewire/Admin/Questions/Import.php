<?php

namespace App\Livewire\Admin\Questions;

use App\Models\Question;
use App\Models\Option;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuestionsTemplateExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Cache;

class Import extends Component
{
    use WithFileUploads;

    public $file;
    public $subject_id = '';
    public $topic_id = '';
    public $difficulty = 'medium';
    
    public $subjects = [];
    public $topics = [];

    public $previewId; // Cache key for preview data
    public $totalFound = 0;
    public $validCount = 0;
    public $step = 1; 
    
    public $successCount = 0;

    public function mount()
    {
        $this->subjects = \App\Models\Subject::all();
    }

    public function updatedSubjectId($value)
    {
        $this->topic_id = '';
        if ($value) {
            $this->topics = \App\Models\Topic::where('subject_id', $value)->get();
        } else {
            $this->topics = [];
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new QuestionsTemplateExport, 'savollar_shabloni.xlsx');
    }

    public function handleUpload()
    {
        $this->validate([
            'file' => 'required|max:10240', 
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'required|exists:topics,id',
        ]);

        $extension = $this->file->getClientOriginalExtension();
        $this->previewId = Str::uuid()->toString();

        if (in_array($extension, ['xlsx', 'xls'])) {
            $this->parseExcel();
        } elseif (in_array($extension, ['docx', 'doc', 'txt'])) {
            $this->parseDelimiterFormat();
        } else {
            $this->addError('file', 'Faqat Excel (.xlsx, .xls) yoki Word/Text (.docx, .txt) fayllari qabul qilinadi.');
            return;
        }

        $this->step = 2;
    }

    protected function parseExcel()
    {
        $data = Excel::toArray([], $this->file->getRealPath());
        $rows = $data[0] ?? [];
        array_shift($rows); // Remove header

        $previewData = [];
        $existingTexts = Question::pluck('text')->map(fn($t) => Str::lower($t))->toArray();

        foreach ($rows as $row) {
            if (empty($row[0])) continue;

            $questionText = trim($row[0]);
            $options = [
                ['text' => trim($row[1] ?? ''), 'letter' => 'A'],
                ['text' => trim($row[2] ?? ''), 'letter' => 'B'],
                ['text' => trim($row[3] ?? ''), 'letter' => 'C'],
                ['text' => trim($row[4] ?? ''), 'letter' => 'D'],
            ];
            $correctLetter = Str::upper(trim($row[5] ?? ''));

            $errors = $this->validateQuestion($questionText, $options, $correctLetter, $existingTexts);

            $previewData[] = [
                'text' => $questionText,
                'options' => $options,
                'correct_letter' => $correctLetter,
                'errors' => $errors,
                'is_valid' => empty($errors)
            ];
        }

        $this->totalFound = count($previewData);
        $this->validCount = collect($previewData)->where('is_valid', true)->count();
        
        Cache::put('import_'.$this->previewId, $previewData, now()->addHours(1));
    }

    protected function parseDelimiterFormat()
    {
        $text = '';
        $extension = $this->file->getClientOriginalExtension();

        if ($extension === 'txt') {
            $text = file_get_contents($this->file->getRealPath());
        } else {
            try {
                $phpWord = IOFactory::load($this->file->getRealPath());
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->addError('file', 'Faylni o\'qishda xatolik yuz berdi.');
                return;
            }
        }

        $blocks = explode('++++', $text);
        $previewData = [];
        $existingTexts = Question::pluck('text')->map(fn($t) => Str::lower($t))->toArray();

        foreach ($blocks as $block) {
            $block = trim($block);
            if (empty($block)) continue;

            $parts = explode('====', $block);
            // Savol matnini olamiz va barcha ortiqcha bo'shliq/yangi qatorlarni boshidan-oxiridan olib tashlaymiz
            $questionText = trim(array_shift($parts)); 
            
            $options = [];
            $correctLetter = '';
            $letters = ['A', 'B', 'C', 'D', 'E', 'F'];

            foreach ($parts as $index => $part) {
                $part = trim($part); // Har bir variantni ham trim qilamiz
                if (empty($part) && $index >= 2) continue; // Bo'sh variantlarni o'tkazib yuboramiz (agar kamida 2ta bo'lsa)
                
                if ($index >= count($letters)) break;
                
                $isCorrect = str_starts_with($part, '#');
                $optionText = $isCorrect ? ltrim($part, '#') : $part;
                
                $options[] = [
                    'text' => trim($optionText), // Variant matnini ham trim qilamiz
                    'letter' => $letters[$index]
                ];

                if ($isCorrect) {
                    $correctLetter = $letters[$index];
                }
            }

            $errors = $this->validateQuestion($questionText, $options, $correctLetter, $existingTexts);

            $previewData[] = [
                'text' => $questionText,
                'options' => $options,
                'correct_letter' => $correctLetter,
                'errors' => $errors,
                'is_valid' => empty($errors)
            ];
        }

        $this->totalFound = count($previewData);
        $this->validCount = collect($previewData)->where('is_valid', true)->count();
        
        Cache::put('import_'.$this->previewId, $previewData, now()->addHours(1));
    }

    protected function validateQuestion($text, $options, $correctLetter, $existingTexts)
    {
        $errors = [];
        if (in_array(Str::lower($text), $existingTexts)) {
            $errors[] = "Bazada mavjud.";
        }

        if (count($options) < 2) {
            $errors[] = "Variantlar kam.";
        }

        if (empty($correctLetter)) {
            $errors[] = "To'g'ri javob belgilanmagan.";
        }

        return array_unique($errors);
    }

    public function getPreviewDataProperty()
    {
        $data = Cache::get('import_'.$this->previewId, []);
        return array_slice($data, 0, 50);
    }

    public function save()
    {
        $data = Cache::get('import_'.$this->previewId, []);
        $validItems = collect($data)->where('is_valid', true);
        
        if ($validItems->isEmpty()) {
            $this->addError('file', 'Import qilish uchun yaroqli savollar topilmadi.');
            return;
        }

        DB::transaction(function () use ($validItems) {
            foreach ($validItems as $item) {
                $question = Question::create([
                    'text' => $item['text'],
                    'topic_id' => $this->topic_id,
                    'difficulty' => $this->difficulty,
                    'points' => Question::getPointsByDifficulty($this->difficulty),
                ]);

                foreach ($item['options'] as $opt) {
                    $question->options()->create([
                        'text' => $opt['text'],
                        'is_correct' => $opt['letter'] === $item['correct_letter']
                    ]);
                }
                $this->successCount++;
            }
        });

        Cache::forget('import_'.$this->previewId);
        session()->flash('message', "{$this->successCount} ta savol muvaffaqiyatli saqlandi.");
        return redirect()->route('admin.questions.index');
    }

    public function resetImport()
    {
        Cache::forget('import_'.$this->previewId);
        $this->reset(['file', 'previewId', 'totalFound', 'validCount', 'step', 'successCount']);
    }

    public function render()
    {
        return view('livewire.admin.questions.import')
            ->layout('components.layouts.admin');
    }
}
