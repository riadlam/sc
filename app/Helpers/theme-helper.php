<?php

use App\Facades\ThemeDataFacade;


function getFooterWidgetArea()
{
    return ThemeDataFacade::getFooterWidgetArea();
}

function getHeaderNavbarArea()
{
    return ThemeDataFacade::getHeaderNavbarArea();
}

function getHeaderBreadcrumbArea()
{
    return ThemeDataFacade::getHeaderBreadcrumbArea();
}

function getAllThemeSlug()
{
    return ThemeDataFacade::getAllThemeSlug();
}

function loadCoreStyle()
{
    return ThemeDataFacade::loadCoreStyle();
}

function loadCoreScript()
{
    return ThemeDataFacade::loadCoreScript();
}

function renderFooterHookBladeFile()
{
    return \App\Facades\ThemeDataFacade::renderFooterHookBladeFile();
}

function getIndividualThemeDetails($theme_slug)
{
    return \App\Facades\ThemeDataFacade::getIndividualThemeDetails($theme_slug);
}

function renderPrimaryThemeScreenshot($theme_slug)
{
    return \App\Facades\ThemeDataFacade::renderPrimaryThemeScreenshot($theme_slug);
}

function getSelectedThemeSlug()
{
    return \App\Facades\ThemeDataFacade::getSelectedThemeSlug();
}

function getSelectedThemeData()
{
    return \App\Facades\ThemeDataFacade::getSelectedThemeData();
}

function getAllThemeDataForAdmin()
{
    return \App\Facades\ThemeDataFacade::getAllThemeDataForAdmin();
}

function getAllThemeData()
{
    return \App\Facades\ThemeDataFacade::getAllThemeData();
}
