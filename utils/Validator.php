<?php
class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): array
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? '';

            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $this->errors[$field][] = "Le champ $field est obligatoire.";
                }

                if ($rule === 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "Le champ $field doit être un email valide.";
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (int) substr($rule, 4);
                    if (strlen((string) $value) < $min) {
                        $this->errors[$field][] = "Le champ $field doit contenir au moins $min caractères.";
                    }
                }

                if (str_starts_with($rule, 'max:')) {
                    $max = (int) substr($rule, 4);
                    if (strlen((string) $value) > $max) {
                        $this->errors[$field][] = "Le champ $field ne peut pas dépasser $max caractères.";
                    }
                }
            }
        }

        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Aplatit le tableau d'erreurs (tableau de tableaux → tableau simple)
     */
    public static function flattenErrors(array $errors): array
    {
        if (empty($errors)) {
            return [];
        }
        return array_merge(...array_values($errors));
    }
}
