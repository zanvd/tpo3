<?php

namespace App\Models;

class VisitSubtype extends Model {
    protected $table = 'VisitSubtype';

    protected $primaryKey = 'visit_subtype_id';

    public function visit_type() {
        return $this->belongsTo(
            'App\Models\VisitType',
            'visit_type_id',
            'visit_type_id'
        );
    }
}
