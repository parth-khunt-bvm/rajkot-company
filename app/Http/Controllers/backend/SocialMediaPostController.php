<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Imports\SocialMediaPostImport;
use App\Models\SocialMediaPost;
use Config;
use Illuminate\Http\Request;

class SocialMediaPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = Config::get('constants.PROJECT_NAME') . ' || Social Media Post List';
        $data['description'] = Config::get('constants.PROJECT_NAME') . ' || Social Media Post List';
        $data['keywords'] = Config::get('constants.PROJECT_NAME') . ' || Social Media Post List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css'
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'social_media_post.js',
        );
        $data['funinit'] = array(
            'SocialMediaPost.init()',
            'SocialMediaPost.add()'
        );
        $data['header'] = array(
            'title' => 'Social Media Post List',
            'breadcrumb' => array(
                'Dashboard' => route('my-dashboard'),
                'Social Media Post List' => 'Social Media Post List',
            )
        );
        return view('backend.pages.social_media_post.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(122, explode(',', $permission_array[0]['permission']))){

            $data['title'] = Config::get('constants.PROJECT_NAME') . " || Add Social Media Post";
            $data['description'] = Config::get('constants.PROJECT_NAME') . " || Add Social Media Post";
            $data['keywords'] = Config::get('constants.PROJECT_NAME') . " || Add Social Media Post";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array();
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'social_media_post.js',
            );
            $data['funinit'] = array(
                'SocialMediaPost.add()'
            );
            $data['header'] = array(
                'title' => 'Add Social Media Post',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Social Media Post List' => route('admin.social-media-post.index'),
                    'Add Social Media Post' => 'Add Social Media Post',
                )
            );
            return view('backend.pages.social_media_post.add', $data);

        }else{
            return redirect()->route('admin.social-media-post.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objSocialMediaPost = new SocialMediaPost();
        $result = $objSocialMediaPost->saveAdd($request);
        if ($result == "added") {
            $return['status'] = 'success';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Social Media Post successfully added.';
            $return['redirect'] = route('admin.social-media-post.index');
        } elseif ($result == 'social_media_post_exists') {
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Social Media Post has already exists.';
        }  else{
            $return['status'] = 'error';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Something goes to wrong';
        }
        echo json_encode($return);
        exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userId = Auth()->guard('admin')->user()->user_type;
        $permission_array = get_users_permission($userId);

        if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(124, explode(',', $permission_array[0]['permission']))){

            $objSocialMediaPost = new SocialMediaPost();
            $data['post'] = $objSocialMediaPost->get_social_meadia_post_details($id);
            $data['title'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Social Media Post";
            $data['description'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Social Media Post";
            $data['keywords'] = Config::get( 'constants.PROJECT_NAME' ) . " || Edit Social Media Post";
            $data['css'] = array(
                'toastr/toastr.min.css'
            );
            $data['plugincss'] = array(
            );
            $data['pluginjs'] = array(
                'toastr/toastr.min.js',
                'pages/crud/forms/widgets/select2.js',
                'validate/jquery.validate.min.js',
            );
            $data['js'] = array(
                'comman_function.js',
                'ajaxfileupload.js',
                'jquery.form.min.js',
                'social_media_post.js',
            );
            $data['funinit'] = array(
                'SocialMediaPost.edit()'
            );
            $data['header'] = array(
                'title' => 'Edit Social Media Post',
                'breadcrumb' => array(
                    'My Dashboard' => route('my-dashboard'),
                    'Social Media Post List' => route('admin.social-media-post.index'),
                    'Edit Social Media Post' => 'Edit Social Media Post',
                )
            );
            return view('backend.pages.social_media_post.edit', $data);
        }else{
            return redirect()->route('admin.social-media-post.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxcall(Request $request){
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objSocialMediaPost = new SocialMediaPost();
                $list = $objSocialMediaPost->getdatatable($request->input('data'));
                echo json_encode($list);
                break;

            case 'social-media-post-view';
            $objSocialMediaPost = new SocialMediaPost();
            $list = $objSocialMediaPost->get_social_meadia_post_details($request->input('data'));
            echo json_encode($list);
            break;

            case 'common-activity':
                $objSocialMediaPost = new SocialMediaPost();
                $data = $request->input('data');
                $result = $objSocialMediaPost->common_activity($data);
                if ($result) {
                    $return['status'] = 'success';
                    if($data['activity'] == 'delete-records'){
                        $return['message'] = 'Social Media Post successfully deleted.';
                    }
                    $return['redirect'] = route('admin.social-media-post.index');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'It seems like something is wrong';
                }

                echo json_encode($return);
                exit;
        }
    }
    
    public function save_import(Request $request){
        $path = $request->file('file')->store('temp');
        $data = \Excel::import(new SocialMediaPostImport($request->file('file')),$path);
        $return['status'] = 'success';
        $return['message'] = 'Social Media Post added successfully.';
        $return['redirect'] = route('admin.social-media-post.index');

        echo json_encode($return);
        exit;
    }
}
