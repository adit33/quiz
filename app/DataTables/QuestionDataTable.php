<?php

namespace App\DataTables;

use App\Models\Question;
use Yajra\DataTables\Services\DataTable;

class QuestionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->rawColumns(['description','status','action'])
            ->addColumn('status',function($query){
                if(is_null($query->answer)){
                    return '<span class="badge badge-success">Sudah di isi</span>';
                }else{
                    return '<span class="badge badge-danger">Belum di isi</span>';   
                }
                
            })
            ->addColumn('action', function($query){
                return '<a href="'.route('question.show',$query->id).'">Lihat</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Question $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Question $model)
    {
        return $model->newQuery()->select('id', 'description', 'created_at', 'updated_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'description',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Question_' . date('YmdHis');
    }
}
