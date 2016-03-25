<?php namespace Sanatorium\Social\Widgets;

class Hooks {

	protected $config = [
		
		'facebook' => [
			'base' => 'https://www.facebook.com/sharer/sharer.php', 
			'params' => [
				'url'  => 'u',
			],
			'shared_count' => [
				'url' => 'http://graph.facebook.com/?id=%s',
				'return_param' => 'shares'
			]
		],

		'twitter' => [
			'base' => 'https://twitter.com/intent/tweet', 
			'params' => [
				'url'  => 'url',
				'tweet' => 'tweet',
				'via'  => 'via',		# twitter username 
			],
			'shared_count' => [
				'url' => 'http://cdn.api.twitter.com/1/urls/count.json?url=%s',
				'return_param' => 'count'
			]
		],

		'google' => [
			'base' => 'https://plus.google.com/share',
			'params' => [
				'url'  => 'url',
			],
		],

		'linkedin' => [
			'base' => 'https://www.linkedin.com/shareArticle',
			'params' => [
				'url' => 'url',
				'text' => 'title',
			],
			'defaults' => [
				'mini' => 'true'
			],
			'shared_count' => [
				'url' => 'http://www.linkedin.com/countserv/count/share?url=%s&format=json',
				'return_param' => 'count'
			]
		],

		'pinterest' => [
			'base' => 'https://www.pinterest.com/pin/create/button/',
			'params' => [
				'url' => 'url',
				'media' => 'media',
				'text' => 'description',
				'hashtags' => 'hashtags',
			],
			'shared_count' => [
				'url' => 'http://api.pinterest.com/v1/urls/count.json?callback=&url=%s',
				'return_param' => 'count'
			]
		],

		'reddit' => [
			'base' => 'http://www.reddit.com/submit/',
			'params' => [
				'url' => 'url'
			]
		]
	];

	public function share($object = null, $class = null)
	{
		$shareable = config('sanatorium-social.shareable');

		$show_shared_counts = config('sanatorium-social.show_shared_counts');

		$links = [];

		// Available object data for different social sources
		$data = [
			'url' 		=> $object->url,
			'text' 		=> $object->product_description,
			'tweet' 	=> substr($object->product_description, 0, 117),		# 140 - 23 for link
			'via' 		=> config('sanatorium-social.twitter_username'),
			'hashtags' 	=> config('platform.site.title'),
			'media'		=> $object->cover_image_url,
		];

		foreach( $shareable as $share => $active ) {

			if ( $active ) {

				$params = [];

				foreach( $this->config[$share]['params'] as $key => $value ) {
					$params[$value] = $data[$key];
				}

				// Add defaults if given
				if ( isset($this->config[$share]['defaults']) ) {
					$params = $this->config[$share]['defaults'] + $params;
				}

				$links[$share] = [
					'share_url' => $this->config[$share]['base'] . '?' . http_build_query($params)
				];

				// Look for count of shared links
				// @todo - this does not work fully, maybe outdated links
				if ( $show_shared_counts && isset($this->config[$share]['shared_count']) ) {

					$raw = @file_get_contents( sprintf($this->config[$share]['shared_count']['url'], $object->url) );

					$result = json_decode($raw, true);

					if ( isset($result[$this->config[$share]['shared_count']['return_param']]) ) {
						$links[$share]['shared_count'] = $result[$this->config[$share]['shared_count']['return_param']];
					}
				}

			}
		}

		return view('sanatorium/social::hooks/share', compact('links', 'show_shared_counts'));
	}

	public function mail()
	{
		$links = [];

		foreach( config('sanatorium-social.links') as $site => $link ) {
			if ( $link )
				$links[$site] = $link;
		}

		return view('sanatorium/social::hooks/mail', compact('links'));
	}

}
