<div class="form-group">
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => $placeholder]) !!}
</div>

<div class="form-group">
    {!! Form::select('bodyRegion', 
        ['Chest'        => 'Chest',
         'Back'         => 'Back',
         'Triceps'      => 'Triceps',
         'Biceps'       => 'Biceps',
         'Legs'         => 'Legs',
         'Shoulders'    => 'Shoulders',
         'Forearms'     => 'Forearms',
         'FullBody'     => 'FullBody'], 
        null, 
        ['class' => 'form-control', 
         'style' => 'width:100%']) 
    !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>