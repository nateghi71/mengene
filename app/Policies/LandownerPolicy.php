<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\Landowner;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class LandownerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the business can view any models.
     *
     * @param \App\Models\Business $business
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Business $business)
    {
        //
    }

    /**
     * Determine whether the business can view the model.
     *
     * @param \App\Models\Business $business
     * @param \App\Models\Landowner $landowner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view($business, Landowner $landowner)
    {
//        $id = Business::where('business_id', auth(')->id())->pluck('id');
//       dd($id);
//        $landowners = Landowner::where('business_id', $id)->where('status', 1)
// fix
        $business = Business::where('user_id', auth()->id())->pluck('en_name')->pop();

        return $business === $landowner->business_en_name
            ? Response::allow()
            : Response::deny('You do not own this landowner.');
    }

    /**
     * Determine whether the business can create models.
     *
     * @param \App\Models\Business $business
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Business $business)
    {
        //
    }

    /**
     * Determine whether the business can update the model.
     *
     * @param \App\Models\Business $business
     * @param \App\Models\Landowner $landowner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($business, Landowner $landowner)
    {
        //fix
        $business = Business::where('user_id', auth()->id())->pluck('en_name')->pop();

        return $business === $landowner->business_en_name
            ? Response::allow()
            : Response::deny('You do not own this landowner.');
    }

    /**
     * Determine whether the business can delete the model.
     *
     * @param \App\Models\Business $business
     * @param \App\Models\Landowner $landowner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($business, Landowner $landowner)
    {
        $business = Business::where('user_id', auth()->id())->pluck('en_name')->pop();

        return $business === $landowner->business_en_name
            ? Response::allow()
            : Response::deny('You do not own this landowner.');
    }

    /**
     * Determine whether the business can restore the model.
     *
     * @param \App\Models\Business $business
     * @param \App\Models\Landowner $landowner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Business $business, Landowner $landowner)
    {
        //
    }

    /**
     * Determine whether the business can permanently delete the model.
     *
     * @param \App\Models\Business $business
     * @param \App\Models\Landowner $landowner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Business $business, Landowner $landowner)
    {
        //
    }
}
