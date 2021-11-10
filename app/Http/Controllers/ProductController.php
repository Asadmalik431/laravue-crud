<?php

// PostController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;
use App\Products;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:191',
            'price' => 'required',
            'body' => 'required'
        ], [
            'title.required' => 'Entering the title is required.',
            'price.required' => 'Entering the price is required.',
            'title.max' => 'Article title length is too long.',
            'body.required' => 'Entering the description is required.'
        ]);
        // return response()->json($request->all());
        $post = new Products([
            'title' => $request->get('title'),
            'price' => $request->get('price'),
            'description' => $request->get('body')
        ]);

        $post->save();

        return response()->json('successfully added');
    }

    public function index()
    {
        return new PostCollection(Products::all());
    }

    public function edit($id)
    {
        $post = Products::find($id);
        return response()->json($post);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:191',
            'description' => 'required'
        ], [
            'title.required' => 'Entering the title is required.',
            'title.max' => 'Article title length is too long.',
            'description.required' => 'Entering the description is required.'
        ]);

        $post = Products::find($id);
        $post->update($request->all());
        return response()->json('successfully updated');
    }

    public function delete($id)
    {
        $post = Products::find($id);

        $post->delete();

        return response()->json('successfully deleted');
    }

    public function ExportProduct(Request $request)
    {
        // return response()->json('successfully deleted');
        $data = new PostCollection(Products::all());
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Title');
        $sheet->setCellValue('B1', 'price');
        $rows = 2;


        foreach($data as $dataKey){

            $dataKey = $dataKey->toArray();
            $sheet->setCellValue('A' . $rows, $dataKey['title']);
            $sheet->setCellValue('B' . $rows, $dataKey['price']);
            $rows++;
        }



        $type='csv';
        $nameString = 'products'.date('His').'.';
        $fileName=$nameString.$type;
        // $response = response()->streamDownload(function() use ($spreadsheet) {
        //     $writer = new Csv($spreadsheet);
        //     $writer->save('php://output');
        //     });
        //     // $response->setStatusCode(200);
        //     // $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //     $response->headers->set('Content-Disposition', 'attachment; filename="'.$fileName.'"');
        //     $response->send();
        $writer = new Csv($spreadsheet);
        
        $writer->save("export/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        $url =  url('/')."/export/".$fileName;
        // if(file_put_contents($fileName,file_get_contents($url))) {
        //     echo "File downloaded successfully";
        // }
        // else {
        //     echo "File downloading failed.";
        // }
        return response()->json($url);
    }
    
}