<div style="text-align:center;padding-top:10px;padding-bottom:10px;">

	@foreach( $links as $site => $link )

		<?php

		switch( $site ) {

			case 'facebook':
				$icon_name = 'facebook31';
			break;

			case 'steam':
				$icon_name = 'steam4';
			break;

			case 'youtube':
				$icon_name = 'youtube18';
			break;

			case 'twitter':
				$icon_name = 'twitter21';
			break;

			case 'tumblr':
				$icon_name = 'tumblr12';
			break;

			case 'microsoft':
				$icon_name = 'msn';
			break;

			case 'linkedin':
				$icon_name = 'linkedin12';
			break;

			case 'playstation':
				$icon_name = 'playstation2';
			break;

			case 'wordpress':
				$icon_name = 'wordpress12';
			break;

			case 'instagram':
				$icon_name = 'instagram12';
			break;

			default:
				$icon_name = $site;
			break;

		}

		?>
		<a href="{{ $link }}" target="_blank" style="display:inline-block;margin-left:15px;margin-right:15px;" class="social-link {{ $site }}-link">

			<img src="{{ Asset::getUrl('sanatorium/social::simpleicon-social-media/svg/'.$icon_name.'.svg') }}" alt="{{ $site }}" width="24" height="24" style="width:24px;height:24px;" class="{{ $site }}">

		</a>

	@endforeach

</div>

<style type="text/css">
.social-link {
	opacity: 0.5;
}
.social-link:hover {
	opacity: 0.9;
}
</style>
