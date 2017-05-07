<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Repositories\UserRepository;

class UserComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $user;

    /**
     * Create a new user composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(UserRepository $user_repo)
    {
        $user_id = session()->get('user_id', 0);
        $this->user = $user_repo->getUserById($user_id);
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('user', $this->user);
    }
}