<?php

namespace Modules\Ibanners\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Ibanners\Entities\Status;

class BannerPresenter extends Presenter
{
    /**
     * @var \Modules\Ibanners\Entities\Status
     */
    protected $status;
    /**
     * @var \Modules\Ibanners\Repositories\BannerRepository
     */
    private $banner;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->banner = app('Modules\Ibanners\Repositories\BannerRepository');
        $this->status = app('Modules\Ibanners\Entities\Status');
    }

    /**
     * Get the previous banner of the current banner
     * @return object
     */
    public function previous()
    {
        return $this->banner->getPreviousOf($this->entity);
    }

    /**
     * Get the next banner of the current banner
     * @return object
     */
    public function next()
    {
        return $this->banner->getNextOf($this->entity);
    }

    /**
     * Get the banner status
     * @return string
     */
    public function status()
    {
        return $this->status->get($this->entity->status);
    }

    /**
     * Getting the label class for the appropriate status
     * @return string
     */
    public function statusLabelClass()
    {
        switch ($this->entity->status) {
            case Status::DRAFT:
                return 'bg-red';
                break;
            case Status::PENDING:
                return 'bg-orange';
                break;
            case Status::PUBLISHED:
                return 'bg-green';
                break;
            case Status::UNPUBLISHED:
                return 'bg-purple';
                break;
            default:
                return 'bg-red';
                break;
        }
    }
}
