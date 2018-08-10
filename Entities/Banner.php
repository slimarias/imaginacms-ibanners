<?php

namespace Modules\Ibanners\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Bcrud\Support\Traits\CrudTrait;
use Modules\Ibanners\Entities\Feature;
use Laracasts\Presenter\PresentableTrait;
use Modules\Ibanners\Presenters\BannerPresenter;

class Banner extends Model
{
    use CrudTrait,  PresentableTrait;

    protected $table = 'ibanners__banners';

    protected $fillable = ['title','code','url','status','options'];
    protected $presenter = BannerPresenter::class;
    protected $fakeColumns = ['options'];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
    */




    protected $casts = [
        'options' => 'array'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'ibanners__banner__category');
    }


    public function setOptionsAttribute($value) {

        $options = json_decode($value);
        //var_dump($value); die();
        if(!empty($options->mainimage)) $options->mainimage = $this->saveImage($options->mainimage,"assets/ibanners/banner/".str_random().".jpg");


        $this->saveFileInOptions($options,'mediafile',"assets/ibanners/banner/mediafile/");

        $this->attributes['options'] = json_encode(json_encode($options));

    }

    public function getOptionsAttribute($value) {

        return json_decode(json_decode($value));

    }

    public function saveFileInOptions(&$options,$attribute,$dest_path) {

        if(property_exists($options,$attribute)) {
            //Simulate a real column so we can use tha function uploadFileToDisk
            $this->attributes[$attribute] = $this->options->{$attribute};
            $this->uploadFileToDisk($options->{$attribute}, $attribute, "publicmedia", $dest_path);

            $options->{$attribute} = $this->attributes[$attribute];

            unset($this->attributes[$attribute]);

        } else {
            $options->{$attribute} = (!empty($this->options->{$attribute}))? $this->options->{$attribute} : '';
        }

    }



    public function saveImage($value,$destination_path)
    {

        $disk = "publicmedia";

        //Defined return.
        if(ends_with($value,'.jpg')) {
            return $value;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path, $image->stream());

            // 3. Save the path to the database

            return $destination_path;
        }

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($destination_path);

            // set null in the database column
            return null;
        }


    }


}