<ul class="dropdown-menu" id="navbarDropdownMenuLink{{$cat_id}}">
    @foreach ($categories as $category)
        @if ($category->children->count() > 0)
            <li class="nav-item dropdown">
                <a class="dropdown-item dropdown-toggle" href="#" id="navbarDropdownMenuLink{{$category->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ $category->name }} <i class="fa fa-angle-right"></i></a>
                @include('categories.partials.child-categories', ['categories' => $category->children])
            </li>
        @else
            <li>
                <a class="dropdown-item" href="{{$category->id}}">  </a>
            </li>
        @endif
    @endforeach
</ul>