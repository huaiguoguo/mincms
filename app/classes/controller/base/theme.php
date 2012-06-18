<?php

 
class Controller_Base_Theme extends \Controller_Base_Public
{
 	public function before()
    {
        // load the theme template
        $this->theme = \Theme::instance();
        $this->theme->add_paths(
		    array(
		        DOCROOT.'themes'
		    ),
		);
		$this->theme->active('default');
		
        // set the page template
        $this->theme->set_template('layouts/homepage');

        // set the page title (can be chained to set_template() too)
        $this->theme->get_template()->set('title', 'My homepage');

        // set the homepage navigation menu
        $this->theme->set_partial('navbar', 'homepage/navbar');

        // define chrome with rounded window borders for the sidebar section
        $this->theme->set_chrome('sidebar', 'chrome/borders/rounded', 'partial');

        // set the partials for the homepage sidebar content
        $this->theme->set_partial('sidebar', 'homepage/widgets/login');
        $this->theme->set_partial('sidebar', 'homepage/widgets/news')->set('users', Model_News::latest(5));

        // call the user model to get the list of logged in users, pass that to the users sidebar partial
        $this->theme->set_partial('sidebar', 'homepage/widgets/users')->set('users', Model_User::logged_in_users());
    }

 	 /**
     * keep the after() as standard as possible to allow custom responses from actions
     */
    public function after($response)
    {
        // If no response object was returned by the action,
        if (empty($response) or  ! $response instanceof Response)
        {
            // render the defined template
            $response = \Response::forge(\Theme::instance()->render());
        }

        return parent::after($response);
    }
}
