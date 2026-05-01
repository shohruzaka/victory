<?php

namespace Database\Seeders;

use App\Models\Duel;
use App\Models\GameResult;
use App\Models\Option;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clear existing data
        Schema::disableForeignKeyConstraints();
        
        Option::truncate();
        Question::truncate();
        Topic::truncate();
        Subject::truncate();
        Duel::truncate();
        GameResult::truncate();
        
        Schema::enableForeignKeyConstraints();

        // 2. Create Subjects and Questions
        
        // --- Subject 1: C++ Programming ---
        $cpp = Subject::create(['name' => 'C++ Programming']);
        $cppTopic = Topic::create([
            'subject_id' => $cpp->id,
            'name' => 'Core Concepts & OOP'
        ]);

        $cppQuestions = [
            [
                'text' => "C++ da 'virtual' kalit so'zi nima uchun ishlatiladi?",
                'difficulty' => 'medium',
                'options' => [
                    ['text' => "Polimorfizm va dinamik bog'lanish (dynamic binding) uchun", 'is_correct' => true],
                    ['text' => "Xotirani tejash uchun", 'is_correct' => false],
                    ['text' => "Dasturni tezroq ishlashi uchun", 'is_correct' => false],
                    ['text' => "Faqat statik funksiyalar uchun", 'is_correct' => false],
                ]
            ],
            [
                'text' => "Qaysi operatorni C++ da qayta yuklab (overload) bo'lmaydi?",
                'difficulty' => 'hard',
                'options' => [
                    ['text' => ":: (Scope resolution operator)", 'is_correct' => true],
                    ['text' => "+ (Addition)", 'is_correct' => false],
                    ['text' => "== (Equality)", 'is_correct' => false],
                    ['text' => "<< (Insertion)", 'is_correct' => false],
                ]
            ],
            [
                'text' => "Destruktor nima?",
                'difficulty' => 'easy',
                'options' => [
                    ['text' => "Obyekt o'chirilayotganda ishlaydigan maxsus funksiya", 'is_correct' => true],
                    ['text' => "Yangi obyekt yaratuvchi funksiya", 'is_correct' => false],
                    ['text' => "Xatolarni ushlab oluvchi blok", 'is_correct' => false],
                    ['text' => "Faqat private a'zolarga ruxsat beruvchi metod", 'is_correct' => false],
                ]
            ],
            [
                'text' => "C++ da 'Encapsulation' nima?",
                'difficulty' => 'medium',
                'options' => [
                    ['text' => "Ma'lumotlar va metodlarni bir blok (klass) ichida birlashtirish", 'is_correct' => true],
                    ['text' => "Bir klassdan boshqa klassga meros berish", 'is_correct' => false],
                    ['text' => "Funksiyalarni turli xil parametrlar bilan ishlatish", 'is_correct' => false],
                    ['text' => "Xotira bilan to'g'ridan-to'g'ri ishlash", 'is_correct' => false],
                ]
            ],
            [
                'text' => "Poynter (pointer) nima?",
                'difficulty' => 'easy',
                'options' => [
                    ['text' => "Xotira manzilini saqlaydigan o'zgaruvchi", 'is_correct' => true],
                    ['text' => "Faqat butun son saqlaydigan o'zgaruvchi", 'is_correct' => false],
                    ['text' => "Klassning nusxasi", 'is_correct' => false],
                    ['text' => "Sikl operatori", 'is_correct' => false],
                ]
            ],
        ];

        foreach ($cppQuestions as $qData) {
            $question = Question::create([
                'topic_id' => $cppTopic->id,
                'text' => $qData['text'],
                'difficulty' => $qData['difficulty'],
                'points' => Question::getPointsByDifficulty($qData['difficulty'])
            ]);

            foreach ($qData['options'] as $oData) {
                Option::create([
                    'question_id' => $question->id,
                    'text' => $oData['text'],
                    'is_correct' => $oData['is_correct']
                ]);
            }
        }

        // --- Subject 2: Data Structures ---
        $ds = Subject::create(['name' => 'Data Structures']);
        $dsTopic = Topic::create([
            'subject_id' => $ds->id,
            'name' => 'Algorithms & Structures'
        ]);

        $dsQuestions = [
            [
                'text' => "Stack ma'lumotlar strukturasi qaysi tamoyil asosida ishlaydi?",
                'difficulty' => 'easy',
                'options' => [
                    ['text' => "LIFO (Last-In-First-Out)", 'is_correct' => true],
                    ['text' => "FIFO (First-In-First-Out)", 'is_correct' => false],
                    ['text' => "Random Access", 'is_correct' => false],
                    ['text' => "Prioritetli navbat", 'is_correct' => false],
                ]
            ],
            [
                'text' => "Binary Search algoritmining o'rtacha murakkabligi (Time Complexity) qanday?",
                'difficulty' => 'medium',
                'options' => [
                    ['text' => "O(log n)", 'is_correct' => true],
                    ['text' => "O(n)", 'is_correct' => false],
                    ['text' => "O(n^2)", 'is_correct' => false],
                    ['text' => "O(1)", 'is_correct' => false],
                ]
            ],
            [
                'text' => "Linked List'ning Massivdan (Array) asosiy ustunligi nimada?",
                'difficulty' => 'medium',
                'options' => [
                    ['text' => "Dinamik o'lcham va oson element qo'shish/o'chirish", 'is_correct' => true],
                    ['text' => "Xotirani kamroq egallashi", 'is_correct' => false],
                    ['text' => "Elementlarga indeks orqali tezkor kirish", 'is_correct' => false],
                    ['text' => "Kesh bilan yaxshi ishlashi", 'is_correct' => false],
                ]
            ],
            [
                'text' => "Qaysi algoritm 'Divide and Conquer' (Bo'lib tashla va hukmronlik qil) uslubiga misol bo'ladi?",
                'difficulty' => 'hard',
                'options' => [
                    ['text' => "Merge Sort", 'is_correct' => true],
                    ['text' => "Bubble Sort", 'is_correct' => false],
                    ['text' => "Insertion Sort", 'is_correct' => false],
                    ['text' => "Selection Sort", 'is_correct' => false],
                ]
            ],
            [
                'text' => "Hash Table'da 'Collision' nima?",
                'difficulty' => 'medium',
                'options' => [
                    ['text' => "Ikki xil kalit uchun bir xil xesh qiymati hosil bo'lishi", 'is_correct' => true],
                    ['text' => "Xotira to'lib qolishi", 'is_correct' => false],
                    ['text' => "Dasturning to'xtab qolishi", 'is_correct' => false],
                    ['text' => "Kalitning noto'g'ri formati", 'is_correct' => false],
                ]
            ],
        ];

        foreach ($dsQuestions as $qData) {
            $question = Question::create([
                'topic_id' => $dsTopic->id,
                'text' => $qData['text'],
                'difficulty' => $qData['difficulty'],
                'points' => Question::getPointsByDifficulty($qData['difficulty'])
            ]);

            foreach ($qData['options'] as $oData) {
                Option::create([
                    'question_id' => $question->id,
                    'text' => $oData['text'],
                    'is_correct' => $oData['is_correct']
                ]);
            }
        }
    }
}
