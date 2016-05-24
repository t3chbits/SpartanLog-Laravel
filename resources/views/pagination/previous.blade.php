@if ($paginator->lastPage() > 1)
	<span class="{{ ($paginator->currentPage() == 1) ? ' hidden' : '' }}">
	    <a href="{{ $paginator->url($paginator->currentPage()-1) }}"
	       class="btn btn-default btn-block">
	       <span class="glyphicon glyphicon-menu-left"></span>
	    </a>
	</span>
@endif