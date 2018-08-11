<?php

namespace App\Exports;

use App\Models\Sail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class SailsExport implements
    FromQuery,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting,
    WithStrictNullComparison
{
    use Exportable;

    /**
     * SailsExport constructor.
     * @param InvoicesRepository $invoices
     */
    public function __construct($start = 0, $end = 0)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $where = array();
        if ($this->start) {
            $where[] = ['created_at','>',$this->start];
        }
        if ($this->end) {
            $where[] = ['created_at','<',$this->end];
        }
        if ($where) {
            return Sail::query()
                ->select('name', 'num', 'created_at')
                ->where($where)
                ->orderBy('created_at','DESC');
        }
        return Sail::query()
            ->select('name', 'num', 'created_at')
            ->orderBy('created_at','DESC');
    }

    /**
     * 创建头部信息
     * @return array
     */
    public function headings(): array
    {
        return [
            '名称',
            '数量',
            '创建时间'
        ];
    }

    /**
     * 设置列格式
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
