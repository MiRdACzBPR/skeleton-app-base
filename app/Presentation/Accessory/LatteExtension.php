<?php

declare(strict_types=1);

namespace App\Presentation\Accessory;

use Latte\Extension;


final class LatteExtension extends Extension
{
    public function getFilters(): array
	{
		return [
			'accessDump' => fn($data): string => self::renderTable($data),
		];
	}

private static function renderTable($data): string
	{
        if ($data instanceof Selection || $data instanceof \Traversable) {
            $data = iterator_to_array($data);
        }

        if (!$data || !is_array($data)) {
            return '<div class="alert alert-warning">Žádná data k zobrazení.</div>';
        }

        $first = reset($data);
        $columns = array_keys($first->toArray());

        $html = '<table class="table table-bordered table-sm table-hover">';
        $html .= '<thead><tr>';
        foreach ($columns as $column) {
            $html .= '<th>' . htmlspecialchars($column) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($columns as $column) {
                $value = $row instanceof ActiveRow
                    ? $row->$column
                    : ($row[$column] ?? '');

                if (in_array($value, [0, 1, true, false], true)) {
                    $value = (bool) $value ? '✅' : '❌';
                }

                $html .= '<td>' . htmlspecialchars((string) $value) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }


	public function getFunctions(): array
	{
		return [];
	}
}
