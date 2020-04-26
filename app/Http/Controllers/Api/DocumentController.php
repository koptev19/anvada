<?php

namespace App\Http\Controllers\Api;

use App\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of the document.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * Store a newly created document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the document.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
		return $document;
    }

    /**
     * Update the document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
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
     * Publish the document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
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
