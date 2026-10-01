<?php

declare(strict_types=1);

namespace FormRequestExpressions;

use App\Http\Requests\DeclaredPropertiesRequest;
use App\Http\Requests\ListElementRulesRequest;
use App\Http\Requests\OffsetAssignedRulesRequest;
use App\Http\Requests\ReassignedRulesRequest;
use Illuminate\Validation\Rule;

use function is_callable;
use function PHPStan\Testing\assertType;

function testReassignedRules(ReassignedRulesRequest $reassigned, OffsetAssignedRulesRequest $offsetAssigned): void
{
    assertType('float|int|non-empty-string', $reassigned->value);
    assertType('float|int|numeric-string', $offsetAssigned->value);
}

function testFirstClassCallables(DeclaredPropertiesRequest $request): void
{
    assertType('true', is_callable($request->validated(...)));
    assertType('true', is_callable($request->input(...)));
    assertType('true', is_callable(Rule::in(...)));
    assertType('true', is_callable($request->safe()->only(...)));
}

function testDeclaredProperties(DeclaredPropertiesRequest $request): void
{
    assertType('mixed', $request->documented);
    assertType('mixed', $request->nativeName);
}

function testAccessForms(DeclaredPropertiesRequest $request, DeclaredPropertiesRequest|null $nullable): void
{
    assertType('non-empty-string|null', $nullable?->name);
    assertType('non-empty-string|null', $nullable?->input('name'));
    assertType('non-empty-string', $request->{'name'});
    assertType('non-empty-string', $request->{'input'}('name'));

    if ($request->nickname === null) {
        return;
    }

    assertType('string', $request->nickname);
}

/**
 * Laravel assembles scalar and empty-array elements first, so validated lists keep their order only without them.
 * A parent assembled from wildcard elements is not known to be present, hence the null.
 */
function testValidatedListOrder(ListElementRulesRequest $request): void
{
    assertType('list<string>|null', $request->validated('scalars'));
    assertType('array<int, array>|null', $request->validated('arrays'));
    assertType('array<int, mixed>|null', $request->validated('any'));
    assertType('list<array{id: float|int|numeric-string}>|null', $request->validated('rows'));
    assertType('list<array>', $request->arrays);
}

/** Keys allowed by an array rule fall under the wildcard rules when they have none of their own. */
function testAllowedKeysWithWildcardRules(ListElementRulesRequest $request): void
{
    assertType('array{theme?: string, locale?: string}', $request->validated('options'));
    assertType("array{beta?: 1|'1'|'on'|'true'|'yes'|true}|null", $request->validated('flags'));
}
