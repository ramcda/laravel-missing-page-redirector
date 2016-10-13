<?php

namespace Spatie\MissingPageRedirector\Test;

use Symfony\Component\HttpFoundation\Response;

class RedirectsMissingPagesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_will_not_interfere_with_existing_pages()
    {
        $this->visit('existing-page')->see('existing page');
    }

    /** @test */
    public function it_will_redirect_a_non_existing_page()
    {
        $this->app['config']->set('laravel-missing-page-redirector.redirects', [
            '/non-existing-page' => '/existing-page'
        ]);

        $this->get('non-existing-page');

        $this->assertRedirectedTo('/existing-page');
    }

    /** @test */
    public function it_will_not_redirect_an_url_that_it_not_configured()
    {
        $this->app['config']->set('laravel-missing-page-redirector.redirects', [
            '/non-existing-page' => '/existing-page'
        ]);

        $this->get('/not-configured');

        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
}
