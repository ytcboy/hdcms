<?php
/** .-------------------------------------------------------------------
 * |  Software: [hdcms framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军大叔 <www.aoxiangjun.com>
 * | Copyright (c) 2012-2019, www.houdunren.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace App\Traits;

use Spatie\Activitylog\Models\Activity;

/**
 * 模块动态
 * Trait ActivityRecord
 * @package App\Traits
 */
trait ActivityRecord
{
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->site_id = \site()['id'];
        $activity->module_id = \module()['id'];
        $activity->module = \module()['name'];
    }
}