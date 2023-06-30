<aside class="bg-dark text-white">

<nav>
    <ul>
        <li><a href="{{ route('admin.home') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.posts.index') }}"><i class="fa-solid fa-list"></i> Elenco Post</a></li>
        <li><a href="{{ route('admin.category_posts') }}"><i class="fa-solid fa-folder-tree"></i> Elenco Catogorie/Post</a></li>
        <li><a href="{{ route('admin.categories.index') }}"><i class="fa-solid fa-folder-tree"></i> Gestione Catogorie</a></li>
        <li><a href="{{ route('admin.tag_posts') }}"><i class="fa-solid fa-tag"></i> Elenco Tag/Post</a></li>
        <li><a href="{{ route('admin.tags.index') }}"><i class="fa-solid fa-tag"></i> Gestione Tag</a></li>
        <li><a href="{{ route('admin.posts.create') }}"><i class="fa-solid fa-square-plus"></i> Nuovo Post</a></li>
    </ul>
</nav>

</aside>
