<?php

$this->gridForm()->addMain($this->form, array(
                                             'label'         => 'Form',
                                             'elements'      => array_keys(array_merge($this->form->getElements(), $this->form->getSubForms()))
                                             //'elements'      => array('body')

                                        ));

echo $this->partial('grid/_form.phtml', $this);
