# Form Components

A set of form components provides support the the styled form elements in the CD Framework. 

## Form

The form component creates the required fieldset and legend.

Use wire:submit on the form component rather than wire:click on the submit button to maintain the 
expected behavior of submitting the form if the user hits enter in a text element.

Here is an example of a simple form:

```
<x-cd.form.form legend="Simple form" wire:submit="submit">
  <x-cd.form.text label="Name" wire:model="name"/>
  <div>
    <x-cd.form.submitbutton/>
    <x-cd.form.resetbutton/>
  </div>
</x-cd.form.form>
```

## Form elements

The `name` and `id` attributes on the form inputs default to the same value as 
that used in the `wire:model` attribute. You may supply different values for `name` and `id  `.
Inputs are not required by default; you can supply the `required="1"` attribute if the input
should be required.

Use the `description` attribute to provide additional instruction or formatting hints.  The description text is displayed below the input.  The component will add an `aria-describedby` attribute to the input to associate the description text with the input. 

## Text

The `placeholder` attribute can be used on text inputs.

To adjust the width of the text input, use the `size` attribute and add the class `use-size-attr`. 

Example:
```
    <x-cd.form.text label="Text Input" wire:model="name"/>
```
## Select

The select form input requires an array of options. 
The options and the component call are demonstrated below. The required attribute is optional.
Making the first option disabled gives it the function of placeholder text. 

```
$this->roleoptions = [
        [ 'value'=>'', 'option'=>'Select a Role', 'disabled'=>true],
        [ 'value'=>'administrator', 'option'=>'Administrator', 'disabled'=>false],
        [ 'value'=>'editor', 'option'=>'Editor', 'disabled'=>false],
        [ 'value'=>'subscriber', 'option'=>'Subscriber', 'disabled'=>false],
    ];
```

```
    <x-cd.form.select :options="$roleoptions" required=1 label="Select" wire:model="role" />
```
You may add the attribute `multiple="multiple"` to create a multiselect.  Multiselect with groups are not yet supported.

## Checkbox

The checkbox component implements a single checkbox (see Checkboxes for multiple checkboxes).
The checkbox component needs a value to return when the box is checked. 

```
    <x-cd.form.checkbox label="Subscribe" value="1" wire:model="subscribe" />
```

## Checkboxes

The checkboxes component implements a set of related checkboxes which are bound to one Livewire variable. 
An array of options define the set of checkboxes as demonstrated here.

```
    $this->checkboxoptions = [
      [ 'value' => "tomato", "label" => "Tomato"],
      [ 'value' => "lettuce", "label" => "Lettuce"],
      [ 'value' => "pickle", "label" => "Pickle"], 
      [ 'value' => "onion", "label" => "Onion"], 
    ]; 
```

```
    <x-cd.form.checkboxes :checkboxes="$checkboxoptions" wire:model="toppings" label="Topping Choices"/>
```

## Special text inputs

The CD Framework provides styling for several special-purpose text inputs. These may be selected
using the `type` attribute, as in the following examples:


```
    <x-cd.form.text type="search" field="search" label="Search" wire:model="search"/>
    <x-cd.form.text type="telephone" label="Telephone" wire:model="telephone"/>
    <x-cd.form.text type="url" label="URL" wire:model="url"/>
    <x-cd.form.text type="email" label="Email" wire:model="email"/>
    <x-cd.form.text type="password" label="Password" wire:model="password"/>
    <x-cd.form.text type="number" label="Number" wire:model="number"/>
    <x-cd.form.text type="datetime" label="Datetime" wire:model="datetime"/>
    <x-cd.form.text type="datetimelocal" label="Datetime Local" wire:model="datetimelocal"/>
    <x-cd.form.text type="date" label="Date" wire:model="date"/>
    <x-cd.form.text type="month" label="Month" wire:model="month"/>
    <x-cd.form.text type="week" label="Week" wire:model="week"/>
    <x-cd.form.text type="time" label="Time" wire:model="time"/>
```
## Range

A range input rendered as a slider may be specified using this special text input which requires
`max` and `min` attributes.

```
    <x-cd.form.text type="range" field="range" required=1 label="Range" min=1 max=10 wire:model="range"/>
```       

## File

The file selector input is also a variant of the text input.
```
    <x-cd.form.text type="file" field="file" required=1 label="File" wire:model="file"/>
```

## Color

The color picker is also a variant of the text input.  Take care to initialize the value of this
input to a valid `value`, which is a hash (#) character followed by six hexadecimal digits. 
```
        <x-cd.form.text type="color" field="color" label="Color" wire:model="color" value="#ff0000"/>
```
        
# Radio Buttons

The `radios` component implements a set of related radio buttons defined by an array of options, as demonstrated below.</p>

```
    <x-cd.form.radios field="radios" required=0 label="Radios" wire:model="radios" :radiobuttons="$radiooptions" />
```

# Submit, Reset and Cancel Buttons

Components are provided for the submit and reset buttons often used in forms.  Since the submit button will cause
the form to call the `wire:submit` function specified in the form element, no `wire:click` is required in that element. 

The reset button will clear the form. 

The cancel button requires a `wire:click` or `x-on:click` attribute to specify the action which should be
taken when the button is pressed. 

```
    <x-cd.form.submitbutton />
    <x-cd.form.resetbutton />
    <x-cd.form.cancelbutton wire:click"closemodal">
```




