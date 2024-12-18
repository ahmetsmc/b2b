<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

trait HasRepositoryRoof
{
    public string $locale;

    public object $errors;

    public int $perBy = 12;

    public array $withEagerLoads = [];

    public User|null $transactionBy = null;

    public function __construct()
    {
        $this->locale = config('app.default_locale');

        $this->errors = new Collection();
    }

    public function success(): bool
    {
        return count($this->errors) < 1;
    }

    public function setError($content): static
    {
        $this->errors->push($content);

        return $this;
    }

    public function errors(): Collection
    {
        return $this->errors;
    }

    public function setUser(User $user): static
    {
        $this->transactionBy = $user;
        return $this;
    }

    public function user(): ?User
    {
        return $this->transactionBy;
    }

    public function setLocale($locale): static
    {
        $this->locale = $locale;
        return $this;
    }

    public function locale()
    {
        return $this->locale;
    }

    public function setPerBy(int $perBy): static
    {
        $this->perBy = $perBy;
        return $this;
    }

    public function setEagerRelations(array $with): static
    {
        $this->withEagerLoads = $with;
        return $this;
    }
}
