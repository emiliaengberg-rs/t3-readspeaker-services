.. include:: ../Includes.txt

.. _using:

===================
Using the Extension
===================

After installing the extension, you should configure it to work the way you want. See the :ref:`configuration` section for more information.

If you want to test out the extension before you start configuring it, you can just fill in the following information:

* :ref:`configuration_wr_paths` > :ref:`configuration_wr_paths_url`
* :ref:`configuration_wr_paths` > :ref:`configuration_wr_paths_api`
* :ref:`configuration_wr_conf` > :ref:`configuration_wr_conf_cid`
* :ref:`configuration_wr_reading` > :ref:`configuration_wr_reading_lang`
* :ref:`configuration_dr` > :ref:`configuration_dr_enable`

This minimal configuration is what is required to get the extension to work with the default settings.

Once you have finished configuring the extension, you should select one of the methods of enabling it. Which one you choose depends on the structure of your website and the level of control you need on each individual page.

* :ref:`using_plugin` - Install on a single page, or just a few pages.
* :ref:`using_main_template` - Install on all pages, with the same settings everywhere.
* :ref:`using_fluid_template` - Install on all pages, with full control over settings on each page.

.. _using_plugin:

Using the Extension as a Plug-in
================================

Use this mode if you want to enable the extension on a single page or just a few pages.

.. rst-class:: bignums-xxl

1. Locate the page

   To use webReader and/or docReader as a plugin, go to *Web > Page* and locate the page where you want it to be added.

   Click on the :guilabel:`+ Content` button where you want webReader to be displayed:

   .. figure:: ../Images/using-plugin-content.png
      :class: with-shadow
      :alt: Adding content to a web page

2. Select plug-in type

   Select *General Plugin* from the *Plugins* tab

   .. figure:: ../Images/using-plugin-pluginstab.png
      :class: with-shadow
      :alt: The plug-ins tab

3. Select ReadSpeaker Services

   Select *ReadSpeaker Services* from the *Plugin* tab

   .. figure:: ../Images/using-plugin-select.png
      :class: with-shadow
      :alt: The plug-in selector

4. Save

   Click on :guilabel:`Save` and then :guilabel:`Close`

   .. figure:: ../Images/using-plugin-save.png
      :class: with-shadow
      :alt: Save the plugin selection

5. Verify that the plug-in is visible on the page

   The plugin should now be visible in the content section:

   .. figure:: ../Images/using-plugin-selected.png
      :class: with-shadow
      :alt: The selected plugin is visible on the page

6. Preview

   If you preview the page you should now see webReader's listen button. It may look something like this:

   .. figure:: ../Images/webreader-frontend.png
      :class: with-shadow
      :alt: The webReader Listen button on the previewed page

   .. note::

      Note that you may have to configure the reading area in order to make webReader read the desired content. See Reading Area ID in the Configuration section for more information.

.. _using_main_template:

Using the Extension in the Main Template
========================================

Use this method if you want the extension to be enabled on all pages in the website, but don't need fine-grained control over the configuration on each page.

.. rst-class:: bignums-xxl

1. Locate the root template

   Go to Web > Template and select the website's root page:

   .. figure:: ../Images/using-main-root.png
      :class: with-shadow
      :alt: Page template list

2. Info/Modify

   Make sure *Info/Modify* is selected in the dropdown at the top of the page:

   .. figure:: ../Images/using-main-infomodify.png
      :class: with-shadow
      :alt: Info/Modify selected in the drop-down menu

3. Set it up

   Now click on *Setup*:

   .. figure:: ../Images/using-main-setup.png
      :class: with-shadow
      :alt: Setup part of template section list

4. Alter the TypoScript code

   webReader can be added as a :typoscript:`FLUIDTEMPLATE` object in the TypoScript code:

   .. code-block:: typoscript

      page.20 = FLUIDTEMPLATE
      page.20 {
         templateName = Webreader
         templateRootPaths {
            10 = EXT:readspeaker_services/Resources/Private/Templates
         }
      }

   Where to insert the code depends on where you want the webReader button to show up. In the example below, the Listen button will always be displayed at the top of the screen, above any page content:

   .. figure:: ../Images/using-main-setupcode.png
      :class: with-shadow
      :alt: Setup TypoScript

5. Save

   Click on :guilabel:`Save` when you are done editing the TypoScript code.

6. Preview

   The result may look something like this:

   .. figure:: ../Images/webreader-frontend-main.png
      :class: with-shadow
      :alt: webReader's Listen button rendered on the frontpage

.. _using_fluid_template:

Using the Extension in a Fluid Template
=======================================

Use this method to gain more control over how the extension functions.

Before you can insert webReader in your Fluid template, you need to declare the extension's namespace:

.. code-block:: typoscript

   {namespace rs=Readspeaker\ReadspeakerServices\ViewHelpers}

Add the namespace declaration at the top of your Fluid template.

webReader's Listen button can be inserted with either :ref:`tag-based <using_fluid_template_tagbased>` or :ref:`inline <using_fluid_template_inline>` notation. Which one you choose is entirely up to you. We will show you both.

Most configuration options can be overridden at the object level using attributes and parameters. This makes for a very flexible approach and gives you a lot of control over each webReader button.

.. _using_fluid_template_tagbased:

Tag-based Notation
------------------

Inserting a webReader Listen button is as simple as just adding a tag::

   <rs:webreaderbutton />

Output:

.. figure:: ../Images/webreader-listen-button.png
   :class: with-shadow
   :alt: webReader's Listen button

----

The above button will inherit all settings from the :ref:`global configuration <configuration>`.
If you want to override the base settings, you can add attributes to your tag. For instance, this will change the button label::

   <rs:webreaderbutton listenLabel="Listen to this article" />

Output:

.. figure:: ../Images/webreader-listen-to-article.png
   :class: with-shadow
   :alt: webReader's Listen button with the label Listen to this article

----

If you want to change multiple settings, just add more attributes::

   <rs:webreaderbutton
      listenLabel="Listen to this article"
      readId="a-specific-aricle-id"
   />

See the :ref:`configuration` chapter for more information on which attributes are available.

.. _using_fluid_template_inline:

Inline Notation
---------------

Inline notation has the same capabilities as :ref:`tag-based <using_fluid_template_tagbased>` notation, but sometimes allows for a more compact syntax.

A plain Listen button can be inserted like this::

   {rs:webreaderbutton()}

Output:

.. figure:: ../Images/webreader-listen-button.png
   :class: with-shadow
   :alt: webReader's Listen button

-----

Altering configuration options can be done by adding parameters::

   {rs:webreaderbutton(
      listenLabel: 'Listen to this article',
      readId: 'a-specific-article-id'
   )}

Output:

.. figure:: ../Images/webreader-listen-to-article.png
   :class: with-shadow
   :alt: webReader's Listen button with the label Listen to this article
