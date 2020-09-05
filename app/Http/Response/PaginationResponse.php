<?php


namespace App\Http\Response;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationResponse
{
	public static function build(LengthAwarePaginator $paginator, callable $processor): array {
		$items = [];

		foreach ($paginator->items() as $item) {
			$items[] = $processor($item);
		}

		return [
			'page' => [
				'currentPage' => $paginator->currentPage(),
				'totalPages' => $paginator->lastPage(),
				'totalItems' => $paginator->total(),
				'perPage' => $paginator->perPage(),
			],
			'items' => $items
		];
	}
}