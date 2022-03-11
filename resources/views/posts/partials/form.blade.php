<div class="form-group">
    <label for="title">Title:</label>
    <input id="title" type="text" name="title" class="form-control" value="{{ old('title', optional($post ?? null)->title) }}">
</div>

<div class="form-group">
    <label for="content">Content:</label>
    <textarea id="content" name="content" class="form-control">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>

<x-errors></x-errors>
