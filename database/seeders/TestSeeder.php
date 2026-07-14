<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Limit;
use App\Models\Option;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => [
                'uz' => 'Jahon adabiyoti',
                'kaa' => 'Jáhán ádebiyatı',
                'ru' => 'Мировая литература'
            ],
            'limit' => 3,
        ]);
        Category::create([
            'name' => [
                'uz' => 'O‘zbek adabiyoti',
                'kaa' => 'Ózbek ádebiyatı',
                'ru' => 'Узбекская литература'
            ],
            'limit' => 3,
        ]);
        Category::create([
            'name' => [
                'uz' => 'Qoraqalpoq adabiyoti',
                'kaa' => 'Qaraqalpaq ádebiyatı',
                'ru' => 'Каракалпакская литература'
            ],
            'limit' => 4,
        ]);
        $books = [
            [
                'name' => [
                    'uz' => 'Abdulhamid Cho‘lpon',
                    'kaa' => 'Abdulhamid Sholpan',
                    'ru' => 'Абдулхамид Чулпан',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'O‘tkan kunlar (Abdulla Qodiriy)',
                    'kaa' => 'Ótken kúnler (Abdulla Qadiriy)',
                    'ru' => 'Минувшие дни (Абдулла Кадырий)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Abdurauf Fitrat',
                    'kaa' => 'Abdurauf Fitrat',
                    'ru' => 'Абдурауф Фитрат',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Abdulla Avloniy',
                    'kaa' => 'Abdulla Avloniy',
                    'ru' => 'Абдулла Авлони',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'G‘ulom Zafariy',
                    'kaa' => 'Ǵulom Zafariy',
                    'ru' => 'Гулям Зафарий',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Tohir va Zuhra',
                    'kaa' => 'Tahir hám Zuhra',
                    'ru' => 'Тохир и Зухра',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Mahmudxo‘ja Behbudiy',
                    'kaa' => 'Mahmudxója Behbudiy',
                    'ru' => 'Махмудходжа Бехбуди',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Munavvar Qori Abdirashidxonov',
                    'kaa' => 'Munavvar Qori Abdirashidxonov',
                    'ru' => 'Мунаввар Кори Абдирашидхонов',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Alpomish dostoni',
                    'kaa' => 'Alpamıs dástánı',
                    'ru' => 'Эпос об Алпамысе',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Rustamxon dostoni',
                    'kaa' => 'Rustamxan dástánı',
                    'ru' => 'Эпос Рустамхана',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Malika Ayyor dostoni',
                    'kaa' => 'Malika Ayyar dástanı',
                    'ru' => 'Поэма Малика Аййер',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Go‘ro‘g‘lining tug‘ilishi dostoni',
                    'kaa' => 'Góruǵlınıń tuwılıwı dástanı',
                    'ru' => 'Поэма о Рождении Гуроглы',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Kecha va kunduz (Abdulhamid Cho‘lpon)',
                    'kaa' => 'Keshe hám kúndiz (Abdulhamid Sholpan)',
                    'ru' => 'Ночь и день (Абдулхамид Чулпан)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Abdulla Oripov she’rlari',
                    'kaa' => 'Abdulla Aripov qosıqları',
                    'ru' => 'Стихи Абдуллы Арипова',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Qo‘shchinor chiroqlari (Abdulla Qahhor)',
                    'kaa' => 'Qosshınar shıraqları (Abdulla Qahhar)',
                    'ru' => 'Огни Кошчинора (Абдулла Каххар)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Mehrobdan chayon (Abdulla Qodiriy)',
                    'kaa' => 'Mexrobtan shayan (Abdulla Qodiriy)',
                    'ru' => 'Скорпион из алтаря (Абдулла Кадыри)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Hind sayyohi (Abdurauf Fitrat)',
                    'kaa' => 'Hind sayaxatshısı (Abdurauf Fitrat)',
                    'ru' => 'Индийский путешественник (Абдурауф Фитрат)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Ko‘hna dunyo (Odil Yoqubov)',
                    'kaa' => 'Eski dúnya (Adil Yakubov)',
                    'ru' => 'Древний мир (Одил Якубов)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Chinor (Asqad Muxtor)',
                    'kaa' => 'Shınar (Asqad Muxtar)',
                    'ru' => 'Чинара (Аскад Мухтар)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Asrga tatigulik kun (Chingiz Aytmatov)',
                    'kaa' => 'Ásirge tatırlıq kún (Shıńǵıs Aytmatov)',
                    'ru' => 'И дольше века длится день (Чингиз Айтматов)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Qiyomat (Chingiz Aytmatov)',
                    'kaa' => 'Qıyamet (Shıńǵıs Aytmatov)',
                    'ru' => 'Судный день (Чингиз Айтматов)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Robinzon Kruzo (Daniel Defo)',
                    'kaa' => 'Robinzon Kruzo (Daniel Defo)',
                    'ru' => 'Робинзон Крузо (Даниэль Дефо)',
                ],
                'category_id' => 1,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Erkin Vohidov she’rlari',
                    'kaa' => 'Erkin Vohidov qosıqları',
                    'ru' => 'Стихи Эркина Вахидова',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Alvido qirol (Ernest Xeminguey)',
                    'kaa' => 'Alvido qirol (Ernest Xeminguey)',
                    'ru' => 'Прощай, король (Эрнест Хемингуэй)',
                ],
                'category_id' => 1,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Fozil odamlar shahri (Abu Nasr Forobiy)',
                    'kaa' => 'Pazıl adamlar qalası (Abu Nasır Farabiy)',
                    'ru' => 'Город добродетельных людей (Фараби)',
                ],
                'category_id' => 2,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Mantiq ut-tayr (Farididdin Attor)',
                    'kaa' => 'Mantiq ut-tayr (Farididdin Attor)',
                    'ru' => 'Мантик ут-тайр (Фаридуддин Аттар)',
                ],
                'category_id' => 1,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Jinoyat va jazo (Feodor Dostoevskiy)',
                    'kaa' => 'Jınayat hám jaza (Feodor Dostoevskiy)',
                    'ru' => 'Преступление и наказание (Фёдор Достоевский)',
                ],
                'category_id' => 1,
                'status' => '1',
            ],
            [
                'name' => [
                    'uz' => 'Shohnoma (Firdavsiy)',
                    'kaa' => 'Shahnama (Firdavsiy)',
                    'ru' => 'Шахнаме (Фирдоуси)',
                ],
                'category_id' => 1,
                'status' => '1',
            ],
        ];
        /*foreach ($books as $book) {
            Book::create([
                'name' => $book['name'],
                'category_id' => $book['category_id'],
                'status' => $book['status'],
            ]);
        }*/
        Option::create([
            'key' => 'per_corrects',
            'value' => '0.4',
        ]);
        Limit::create([
            'name' => 'Badiiy adabiyot: 10-12 ta (20.00 ball)',
            'min' => 18,
            'max' => 20,
        ]);
        Limit::create([
            'name' => 'Badiiy adabiyot: 7-9 ta (15.00 ball)',
            'min' => 14,
            'max' => 17.99,
        ]);
        Limit::create([
            'name' => 'Badiiy adabiyot: 4-6 ta (10.00 ball)',
            'min' => 10,
            'max' => 13.99,
        ]);
        Limit::create([
            'name' => 'Badiiy adabiyot: 0 ta (0.00 ball)',
            'min' => 0,
            'max' => 9.99,
        ]);
    }
}
