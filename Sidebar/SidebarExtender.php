<?php

namespace Modules\Ibanners\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\User\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {

            $group->item(trans('ibanners::common.ibanners'), function (Item $item) {
                $item->icon('fa fa-copy');

                $item->item(trans('ibanners::category.list'), function (Item $item) {
                    $item->icon('fa fa-file-text');
                    $item->weight(5);
                    $item->append('crud.ibanners.category.create');
                    $item->route('crud.ibanners.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('ibanners.categories.create')
                    );
                });

                $item->item(trans('ibanners::banner.list'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(5);
                    $item->append('crud.ibanners.banner.create');
                    $item->route('crud.ibanners.banner.index');
                    $item->authorize(
                        $this->auth->hasAccess('ibanners.banners.index')
                    );
                });



                $item->authorize(
                    $this->auth->hasAccess('ibanners.categories.index')
                );

            });


        });

        return $menu;
    }
}
