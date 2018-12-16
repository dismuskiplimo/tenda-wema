<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Image;

use App\{User, UserPhoto};

class ImageController extends Controller
{
    public function __construct(){
        $this->initialize();
        $this->middleware('check_coins');
    }

    public function updateProfilePicture(Request $request){
        if($request->hasFile('image') && $request->file('image')->isValid()){
            try{
                $this->validate($request,[
                    'image' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
                ]);
            }catch(\Exception $e){
                session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
                
                return redirect()->back();
            }

            $user = auth()->user();

            if(!$user){
                $message = 'User not found';
                session()->flash('error', $message);
                return redirect()->back();
            }

            if(!empty($user->thumbnail) && !empty($user->image)){
                
                $image_path = $this->image_path . '/' . $user->image;
                $thumbnail_path = $this->image_path . '/' . 'thumbnails' . '/' . $user->thumbnail;

                $user->image = null;
                $user->thumbnail = null;
       
                @unlink($image_path);
                @unlink($thumbnail_path);
            }

            try{
                $file       = $request->file('image');
                $name   	= time(). rand(1,10000000) . '.' . $file->getClientOriginalExtension();
                
                $image_path         = $this->image_path . '/' . $name;
                $thumbnail_path     = $this->image_path . '/' .'thumbnails'. '/' . $name;
            
                Image::make($file)->orientate()->fit(450,450)->save($image_path);
                Image::make($file)->orientate()->fit(64,64)->save($thumbnail_path);

                $user->image      	= $name;
                $user->thumbnail    = $name;
                $user->update();

                session()->flash('success', 'Profile Picture Updated');

            } catch(\Exception $e){
                session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
            }
            
        }

        return redirect()->back();
    }

    public function postUserPhoto(Request $request){
        if($request->hasFile('image') && $request->file('image')->isValid()){
            try{
                $this->validate($request,[
                    'image' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
                ]);
            }catch(\Exception $e){
                session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
                
                return redirect()->back();
            }

            $user = auth()->user();

            if(!$user){
                $message = 'User not found';
                session()->flash('error', $message);
                return redirect()->back();
            }

            try{
                $image       = $request->file('image');
                $name        = time(). rand(1,10000000) . '.' . $image->getClientOriginalExtension();
                
                $image_path         = $this->image_path . '/user_photos/images/' . $name;
                $thumbnail_path     = $this->image_path . '/user_photos/thumbnails'. '/' . $name;
            
                Image::make($image)->orientate()->resize(800,null, function($constraint){
                    return $constraint->aspectRatio();
                })->save($image_path);

                Image::make($image)->orientate()->fit(300,180)->save($thumbnail_path);

                $user_photo                 = new UserPhoto;
                $user_photo->user_id        = $user->id ;
                $user_photo->photo          = $name ;
                $user_photo->thumbnail      = $name;
                $user_photo->save();
                
                $user->image        = $name;
                $user->thumbnail    = $name;
                $user->update();

                session()->flash('success', 'Photo added');

            } catch(\Exception $e){
                session()->flash('error', 'Image Upload failed. Reason: '. $e->getMessage());
            }
            
        }

        return redirect()->back();
    }

    public function deleteUserPhoto($id){
        $photo = UserPhoto::findOrFail($id);

        if($photo->user_id == auth()->user()->id){
            @unlink($this->image_path . '/user_photos/images/' . $photo->photo);
            @unlink($this->image_path . '/user_photos/thumbnails/' . $photo->thumbnail);

            $photo->delete();

            session()->flash('success', 'Photo removed');

        }else{
            session()->flash('error', '403 : Forbidden');
            
        }

        return redirect()->back();
    }
}
