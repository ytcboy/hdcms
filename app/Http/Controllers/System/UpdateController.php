<?php

namespace App\Http\Controllers\System;

use GuzzleHttp\Client;
use Houdunwang\WeChat\Build\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 系统更新
 * Class UpdateController
 * @package App\Http\Controllers\System
 */
class UpdateController extends Controller
{
    protected $client;
    protected $host = 'http://test.hdcms.com/api/app';

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->host . '/cms/']);
    }

    /**
     * 检测更新
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check()
    {
        $build = 2009;
        $response = $this->client->request('GET', "$build");
        $update = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        //检测目录权限
        foreach ($update['files'] as $file => $stat) {
            if (!is_writable('../' . dirname($file))) {
                return back()->with('info', dirname($file) . '目录\r\n没有写入权限,不能执行更新操作');
            }
        }
        if ($update['build']) {
            \Cache::forever('updateLists', $update);
        }
        return view('system.update.check', compact('update'));
    }

    /**
     * 下载界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function downloadShow()
    {
        $update = \Cache::get('updateLists');
        return view('system.update.download_show', compact('update'));
    }

    /**
     * 执行下载
     * @return array|\Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download()
    {
        $cache = \Cache::get('updateLists');
        if (!$cache) {
            return redirect()->route('cloud.update.check');
        }
        foreach ($cache['files'] as $file => $stat) {
            if ($stat != 'downloaded') {
//                try {
                $this->downFile($file);
                return response(['message' => "file"]);
//                } catch (\Exception $exception) {
//                    return response('下载失败：' . $exception->getMessage(), '500');
//                }
            }
        }
        \Cache::forget('updateLists');
        return response(['message' => 'success']);
    }

    /**
     * 下载文件
     * @param string $file
     * @return null
     * @throws \GuzzleHttp\Exception\GuzzleException | \Exception
     */
    protected function downFile(string $file)
    {
        throw new \Exception('文件下载失败');
        $response = $this->client->request('POST', "file", ['form_params' => ['file' => $file]]);
        if ($response->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            \Storage::drive('base')->makeDirectory('backup/cms/' . dirname($file));
            if (!file_put_contents('../backup/cms/' . $file, $content)) {
                throw new \Exception('文件保存失败');
            }
            $cache['files'][$file] = 'downloaded';
            \Cache::forever('updateLists', $cache);
        }
        throw new \Exception('文件下载失败');
    }

    /**
     * 移动文件
     */
    protected function moveFile()
    {
        try {
            \Artisan::call('migrate');
            $cache = \Cache::get('updateLists');
            $backupPath = "backup/{$cache['build']}";
            \Storage::drive('base')->makeDirectory($backupPath);
            //备份原文件
            foreach ($cache['files'] as $file => $stat) {
                \Storage::drive('base')->copy($file, "{$backupPath}/{$file}");
            }
            //移动文件
            foreach ($cache['files'] as $file => $stat) {
                \Storage::drive('base')->move("backup/cms/{$file}", $file);
            }
            return \Cache::forever('updateLists', $cache);
        } catch (\Exception $exception) {

        }

    }

    /**
     * 下载完成
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish()
    {
        return view('system . update . finish');
    }
}