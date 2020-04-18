<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Document;

class DocumentController extends Controller
{

    /**
     * Возвращает список документов с пагинацией
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
	public function show()
	{
		$perPage = request('perPage', 5);
		$documents = Document::latest()->paginate($perPage);
		$response = [
			'document'   => $documents->items(),
			'pagination' => [
				'page'        => $documents->currentPage(),
				'total'        => $documents->total(),
				'per_page'     => $documents->perPage(),
			]
		];

		return response()->json($response, 200);
	}

    /**
     * Возвращает один документ
     *
     * @param  Document  $document
     * @return Document
     */
	public function one(Document $document)
	{
		return $document;
	}

    /**
     * Создает новый документ со статусом 'Черновик' и сохраняет его.
	 * Возвращает только что созданный документ.
     *
     * @param  Illuminate\Http\Request $request
     * @return Symfony\Component\HttpFoundation\Response
     */
	public function store(Request $request)
	{
		$document = new Document;
		$document->{$document->getKeyName()} = (string) Str::uuid();
		$document->status = Document::STATUSES['draft'];
		$document->payload = new \stdClass;
		$document->save();
		$response = [
			'document'   => $document
		];
		return response()->json($response, 200);
	}

    /**
     * Сохраняет документ, если он черновик. Сохраняется только свойство payload из Request
	 * В случае, если этого поля нет, то возвращает ошибку 400
     *
     * @param  Illuminate\Http\Request $request
     * @param  Document $document
     * @return Symfony\Component\HttpFoundation\Response
     */
	public function update(Request $request, Document $document)
	{
		$document_input = $request->input('document');
		if(isset($document_input['payload']))
		{
			if($document->status == Document::STATUSES['draft'])
			{
				$document->update(['payload' => $document_input['payload']]);
			}
			$response = [
				'document'   => $document
			];
			return response()->json($response, 200);
		}
		$response = [
			'error'   => "Payload doesn`t exist"
		];
		return response()->json($response, 400);
	}

    /**
     * Опубликовывает документ из черновика.
     *
     * @param  Illuminate\Http\Request $request
     * @param  Document $document
     * @return Symfony\Component\HttpFoundation\Response
     */
	public function publish(Request $request, Document $document)
	{
		$document->update(['status' => Document::STATUSES['published']]);
		$response = [
			'document'   => $document
		];
		return response()->json($response, 200);
	}

}
