<?php

namespace App\DataTables;

use App\Admin;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminDataTable extends dataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
			->addColumn('checkbox', 'admin.admins.btn.checkbox')
            ->addColumn('edit', 'admin.admins.btn.edit')
			->addColumn('delete', 'admin.admins.btn.delete')
			->rawColumns([
				'edit',
                'delete',
                'checkbox',
			]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Admin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Admin $model)
    {
        return Admin::query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('admin-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                
                    ->parameters([
                        'dom'        => 'Blfrtip',
                        'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, trans('admin.all_record')]],
                        'buttons'    => [
                            [
                                'text' => '<i class="fa fa-plus"></i> '.trans('admin.create_admin'), 'className' => 'btn btn-info',
                                 "action" => "function(){
                                    window.location.href = '".\URL::current()."/create';}"
                                ],
                            ['extend'   => 'print', 'className'   => 'btn btn-primary', 'text'   => '<i class="fa fa-print"></i>'],
                            ['extend'   => 'csv', 'className'   => 'btn btn-info', 'text'   => '<i class="fa fa-file"></i> '.trans('admin.ex_csv')],
                            ['extend'   => 'excel', 'className'   => 'btn btn-success', 'text'   => '<i class="fa fa-file"></i> '.trans('admin.ex_excel')],
                            ['extend'   => 'reload', 'className'   => 'btn btn-default', 'text'   => '<i class="fa fa-refresh"></i>'],
                            ['text' => '<i class="fa fa-trash"></i>', 'className' => 'btn btn-danger delBtn'],
        
                        ],
                        'initComplete' => " function () {
                            this.api().columns([2,3,4]).every(function () {
                                var column = this;
                                var input = document.createElement(\"input\");
                                $(input).appendTo($(column.footer()).empty())
                                .on('keyup', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }",
                        'language' => datatable_lang(),

                        ]);


    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
				'name'       => 'checkbox',
				'data'       => 'checkbox',
				'title'      => '<input type="checkbox" class="check_all" onclick="check_all()" />',
				'exportable' => false,
				'printable'  => false,
				'orderable'  => false,
				'searchable' => false,
			],
            Column::make('id')
                ->title('ID'),
            Column::make('name')
                ->title(trans('admin.admin_name')),
            Column::make('email')
                ->title(trans('admin.admin_email')),
            Column::make('created_at')
                ->title(trans('admin.created_at')),
            Column::make('updated_at')
                ->title(trans('admin.updated_at')),
            Column::computed('edit')
                ->title(trans('admin.edit'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::computed('delete')
                ->title(trans('admin.delete'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin_' . date('YmdHis');
    }
}
