<?php namespace Kowali\Contents\Controllers\Validators;

class Validator {

    /**
     * The rules to validate the input against
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Return the rules to validate the input against
     *
     * @param  array $input
     * @return array
     */
    public function getRules(array $input = [])
    {
        return $this->rules;
    }

    /**
     * Validate the input against a predifened set of rules
     *
     * @param  array $input
     * @return boolean
     */
    public function validate(array $input)
    {
        $v = \Validator::make($input, $this->getRules($input));

        $this->validator = $v;

        return $v->passes();
    }

    /**
     * Return the errors associated with the last invocation of $validator
     *
     * @return  mixed
     */
    public function errors()
    {
        return $this->validator;
    }
}
