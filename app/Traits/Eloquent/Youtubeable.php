<?php


namespace App\Traits\Eloquent;

use Illuminate\Support\Facades\Storage;
use YoutubeDl\YoutubeDl;

trait Youtubeable
{

    /**
     * initiates loading via python library on url in storage
     *
     * @param $url
     * @param string $folder
     * @param string $storage
     * @return array
     * @throws \Exception
     */
    public function initiateDownload($url, $folder = 'uploads', $storage = 'public')
    {
        $dl = new YoutubeDl([
            'extract-audio' => true,
            'audio-format' => 'mp3',
            'audio-quality' => 0, // best
            'output' => '%(title)s.%(ext)s',
        ]);
        $dl->setDownloadPath(Storage::disk($storage)->getDriver()->getAdapter()->getPathPrefix() . $folder);
        if (env('PYTHON_PATH') !== '') {
            $dl->setPythonPath(env('PYTHON_PATH'));
        }
        $video = $dl->download($url);

        return ['name' => $video['title'], 'filename' => $video['_filename']];
    }

    /**
     * renames from name to id
     *
     * @param $id
     * @param $name
     * @param string $folder
     * @param string $storage
     * @return bool
     */
    public function endDownload($id, $name, $folder = 'uploads', $storage = 'public') {
        $path = Storage::disk($storage)->move($folder . '/' . $name, '/' . $folder . '/' . $id . '.mp3');
        return $path;
    }
}
