<?php

namespace App\Http\Controllers;

use App\Services\PictureService;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    protected $pictureService;

    public function __construct(PictureService $pictureService)
    {
        $this->pictureService = $pictureService;
    }

    public function getMediaLinkById(Request $request)
    {
        $id = $request->route('id');
        return $this->pictureService->getMediaLinkById($id);
    }
}
