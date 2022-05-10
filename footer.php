  <aside role="sidebar" class="bg-slate-300 pt-12 pb-8 text-slate-600">
    <div class="container mx-auto grid grid-cols-3 gap-8">
      <?php dynamic_sidebar('footer-1') ?>
    </div>
  </aside>
  <footer class="bg-slate-300 text-slate-500 text-sm">
    <div class="container flex align-center justify-between mx-auto border-t border-slate-400/70 py-6">
      <p>&copy; Copyright <?php echo gmdate('Y') ?> &middot; <?php bloginfo('name') ?><small class="font-mono"> &mdash; Theme by <a href="https://valiantweb.co/" class="text-slate-500">Valiant Web</a></small></p>
      <a href="#" class="text-slate-500">Back to top &uarr;</a>
    </div>
  </footer>
<?php wp_footer(); ?>
</body>

</html>