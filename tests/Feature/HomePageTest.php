<?php

test('the home page renders the landing page', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertViewIs('home')
        ->assertSee('lang="hu"', false)
        ->assertSee('Tárgyak, amelyek kiállják az idő próbáját')
        ->assertSee('Munkáink')
        ->assertSee('Acél kényelmi eszközök')
        ->assertSee('id="contact-modal"', false);
});

test('the footer renders the static menu and contact details', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSeeInOrder(['Menü', 'Munkáink', 'Stúdió', 'Folyamat', 'Kapcsolat'])
        ->assertSee('Ipari formatervező stúdió Budapesten.')
        ->assertSee('1061 Budapest Fém utca 99.')
        ->assertSee('href="mailto:studio@fem.hu"', false)
        ->assertSee('href="tel:+3612345678"', false)
        ->assertSee('FÉM Stúdió — Minden jog fenntartva')
        ->assertSeeInOrder(['Adatvédelem', 'Impresszum']);
});
