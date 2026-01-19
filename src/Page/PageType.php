<?php

namespace AutoSEO\Page;

enum PageType: string
{
    case HOME = 'home';
    case ARTICLE = 'article';
    case PRODUCT = 'product';
    case STATIC = 'static';
    case SEARCH = 'search';
}
