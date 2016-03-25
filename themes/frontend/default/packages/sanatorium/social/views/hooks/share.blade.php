@if ( isset($links) )

	<ul class="social-share">

	@foreach( $links as $share => $link )

		<li class="social-share-li social-share-li-{{ $share }}">
			
			<a href="{{ $link['share_url'] }}" target="_blank">

				<i class="fa fa-{{ $share }}"></i>
				
				@if ( $show_shared_counts && isset($link['shared_count']) )
					
					<span class="shared-count">
						
						{{ $link['shared_count'] }}

					</span>

				@endif

			</a>

		</li>

	@endforeach

	</ul>

@endif