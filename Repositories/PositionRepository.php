<?php namespace Modules\Ibanners\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface PositionRepository extends BaseRepository
{

    /**
     * Get all the read notifications for the given filters
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItemsBy($params);

    /**
     * Get the read notification for the given filters
     * @param string $criteria
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItem($criteria, $params);

    /**
     * Get all online sliders
     * @return object
     */
    public function allOnline();
}
