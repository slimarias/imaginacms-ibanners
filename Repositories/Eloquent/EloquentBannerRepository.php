<?php

namespace Modules\Ibanners\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ibanners\Entities\Banner;
use Modules\Ibanners\Entities\Status;
use Modules\Ibanners\Repositories\Collection;
use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Laracasts\Presenter\PresentableTrait;

class EloquentBannerRepository extends EloquentBaseRepository implements BannerRepository
{
    /**
     * @param  int $id
     * @return object
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Update a resource
     * @param $banner
     * @param  array $data
     * @return mixed
     */
    public function update($banner, $data)
    {
        $banner->update($data);



        //event(new BannerWasUpdated($banner, $data));

        return $banner;
    }

    /**
     * Create a ibanners banner
     * @param  array $data
     * @return Banner
     */
    public function create($data)
    {
        $banner = $this->model->create($data);



        event(new BannerWasCreated($banner, $data));

        return $banner;
    }

    public function destroy($model)
    {
        //event(new BannerWasDeleted($model->id, get_class($model)));

        return $model->delete();
    }


    /**
     * Return the latest x ibanners banners
     * @param int $amount
     * @return Collection
     */
    public function latest($amount = 5)
    {
        return $this->model->whereStatus(Status::PUBLISHED)->orderBy('created_at', 'desc')->take($amount)->get();
    }

    /**
     * Get the previous banner of the given banner
     * @param object $banner
     * @return object
     */
    public function getPreviousOf($banner)
    {
        return $this->model->where('created_at', '<', $banner->created_at)
            ->whereStatus(Status::PUBLISHED)->orderBy('created_at', 'desc')->first();
    }

    /**
     * Get the next banner of the given banner
     * @param object $banner
     * @return object
     */
    public function getNextOf($banner)
    {
        return $this->model->where('created_at', '>', $banner->created_at)
            ->whereStatus(Status::PUBLISHED)->first();
    }

    /**
     * Find a resource by the given slug
     *
     * @param  string $slug
     * @return object
     */
    public function findBySlug($slug)
    {

        return $this->model->where('url', $slug)->whereStatus(Status::PUBLISHED)->firstOrFail();
    }

    public function whereCategory($id)
    {

        return $this->model->whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->orderBy('created_at', 'DESC')->paginate(12);

    }
}
