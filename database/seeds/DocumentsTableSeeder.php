<?php

use Illuminate\Database\Seeder;
use App\Document;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Очищаем таблицу
        Document::truncate();

        $faker = \Faker\Factory::create();

		// Создаем чистый payload и вносим в него какие-то данные
		$payload = new \stdClass;
		$payload->actions = ['action' => 'eat', 'actor' => 'Bob']; 

        // Создаем 20 записей
        for ($i = 0; $i < 20; $i++) {
			$payload->title = $faker->sentence;
			$document = new Document;
			$document->{$document->getKeyName()} = $faker->uuid();
			$document->status = Document::STATUSES[array_rand(Document::STATUSES)];
			$document->payload = $payload;
			$document->save();
        }
    }
}
