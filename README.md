### Adding JSON Responses to an Application [![Build Status](https://travis-ci.org/mehlah/li3_jbuilder.png?branch=master)](https://travis-ci.org/mehlah/li3_jbuilder)

To demonstrate the befinits of this libary, we’ll use a simple application.
This app has many `discussions` and we’d like to add a JSON representation for each `discussion`
that we can fetch by appending `.json` to the discussion’s URL.
If we try this we’ll see the JSON representation of the discussion.

![](http://c1352201.r1.cf3.rackcdn.com/1343089908.jpg)

### Customizing The Response

The JSON returned includes all of the discussion’s attributes but what if we want to customize it?
This is where things can start to get ugly. We can call `to('json')` on the discussion and customize
what’s returned.
Let’s say that we want the id, subject and content fields from the discussion along with its author
and the same fields from the discussion’s messages.

```php
public function show() {
	$discussion = Discussions::find($this->request->id);

	if (!$discussion) {
		return $this->redirect('/discussions');
	}

	if ($this->request->is('json')) {
		// we don't want to expose this
		unset($discussion->created_at);

		// additional data comes from associated Author and Comments records.
		$discussion->author = [
			'name' => 'Mehdi Lahmam B.',
			'id' => '1234'
			];
		$discussion->comments = [
			['content' => 'w00t', 'author' => 'John Doe'],
			['content' => 'This is sexy', 'author' => 'Jimmy']
		];

		return compact('discussion');
	}

	return compact('discussion');
}
```

We can try this by reloading the page again. When we do we see the customized JSON response including the associated Author and Comments records.

![](http://c1352201.r1.cf3.rackcdn.com/1343090633.jpg)

This works, but the code we’ve used isn’t very pretty.

### A better way

Coming soon !


#### Credits

Loosely based on the [original](https://github.com/rails/jbuilder), and a [PHP port](https://github.com/dhotson/JBuilder-php)