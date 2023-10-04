<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $type
 * @property Professionalselection[] $professionalselections
 */
class Selection extends Model
{
    // we hidde pivot info
    protected $hidden = ['pivot'];

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'selection';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function professionalselections()
    {
        return $this->hasMany('App\Professionalselection', 'selection_id');
    }

    public static function validateSelection($selection){

        // Check if selection is array
        if(!is_array($selection))
            return false;

        $filterSelection = [];

        foreach ($selection as $value)  
            if(($selectionObject = Selection::find($value)) != null)
                $filterSelection[] = $selectionObject;

        return $filterSelection;
    }
}
