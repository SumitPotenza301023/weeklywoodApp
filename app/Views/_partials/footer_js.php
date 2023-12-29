 <!-- General JS Scripts -->
 <script src="<?php echo base_url() . JSPATH; ?>/app.min.js"></script>
 <!-- JS Libraies -->
 <!-- Page Specific JS File -->
 <!-- Template JS File -->
 <script src="<?= base_url() . JSPATH ?>/scripts.js"></script>

 <!-- JS Libraies -->
 <!-- <script src="<?= base_url() . JSLIB ?>/apexcharts/apexcharts.min.js"></script> -->
 <script src="<?= base_url() . JSPATH ?>/page/index.js"></script>
 <script src="<?= base_url() . JSPATH ?>/iziToast.min.js"></script>
 <script src="<?= base_url() . JSPATH ?>/sweetalert.min.js"></script>
 <!-- JS Libraies -->
 <script src="<?= base_url() . JSLIB ?>/datatables/datatables.min.js"></script>

 <script src="<?= base_url() . JSLIB ?>/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url() . JSLIB ?>/jquery-ui/jquery-ui.min.js"></script>
 <script src="<?= base_url() . JSPATH ?>/bootstrap-tagsinput.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/owlcarousel2/dist/owl.carousel.min.js"></script>
 <!-- Page Specific JS File -->

 <script src="<?= base_url() ?>/public/assets/bundles/select2/dist/js/select2.full.min.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/summernote/summernote-bs4.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/bootstrap-daterangepicker/daterangepicker.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/dropzonejs/min/dropzone.min.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/tinymce/js/tinymce.min.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/jquery-validation/jquery.validate.min.js"></script>
 <script src="<?= base_url() ?>/public/assets/bundles/jquery-validation/additional-methods.min.js"></script>

 <!-- Page Specific JS File -->
 <script src="<?= base_url() . JSPATH ?>/page/datatables.js"></script>
 <script src="<?= base_url() . JSPATH ?>/page/ion-icons.js"></script>
 <script>
   var weekly = {
     config: {
       login: "<?php echo base_url("/login/autenticate"); ?>",
       updateprofile: "<?php echo base_url("/admin/dashboard/edit_profile"); ?>",
       resetpassword: "<?php echo base_url("/admin/dashboard/update_password"); ?>",
       forgot_password_mail: "<?php echo base_url("/login/forgot_password_mail"); ?>",
       verify_code: "<?php echo base_url("/login/verify_code"); ?>",
       reset_form: "<?php echo base_url("/login/reset_form"); ?>",
       add_contest: "<?php echo base_url("/admin/contests/create_contest"); ?>",
       contest_list: "<?php echo base_url('/admin/contests/contest_details') ?>",
       get_contest: "<?php echo base_url('/admin/contests/get_contest_details') ?>",
       edit_contest: "<?php echo base_url('/admin/contests/edit_contest_details') ?>",
       make_contest_official: "<?php echo base_url('/admin/contests/make_contest_official') ?>",
       get_contest_result: "<?php echo base_url('/admin/contests/get_contest_result') ?>",
       delete_contest: "<?php echo base_url('/admin/contests/delete_contest') ?>",
       upload_banner: "<?php echo base_url('/admin/banners/upload_banner') ?>",
       get_banner: "<?php echo base_url('/admin/banners/get_banner') ?>",
       delete_banner: "<?php echo base_url('/admin/banners/delete_banner') ?>",
       banner_status: "<?php echo base_url('/admin/banners/update_status') ?>",
       get_banner_slider: "<?php echo base_url('/admin/banners/get_banner_slider') ?>",
       add_promocode: "<?php echo base_url('/admin/promocodes/add_promocode') ?>",
       get_all_promocodes: "<?php echo base_url('/admin/promocodes/promocode_details') ?>",
       get_promocode: "<?php echo base_url('/admin/promocodes/get_promocode') ?>",
       edit_promocode: "<?php echo base_url('/admin/promocodes/edit_promocode') ?>",
       delete_promocode: "<?php echo base_url('/admin/promocodes/delete_promocode') ?>",
       add_user: "<?php echo base_url('/admin/users/add_user') ?>",
       get_user: "<?php echo base_url('/admin/users/getusers') ?>",
       delete_user: "<?php echo base_url('/admin/users/delete_user') ?>",
       block_user: "<?php echo base_url('/admin/users/block_user') ?>",
       unblock_user: "<?php echo base_url('/admin/users/unblock_user') ?>",
       get_userdetails: "<?php echo base_url('/admin/users/get_userdetails') ?>",
       edit_user: "<?php echo base_url('/admin/users/edit_user') ?>",
       access_control: "<?php echo base_url('/admin/users/access_control') ?>",
       update_point: "<?php echo base_url('/admin/settings/update_point') ?>",
       update_firebase_setting: "<?php echo base_url('/admin/settings/update_firebase_setting') ?>",
       add_page: "<?php echo base_url('/admin/cms/add_page') ?>",
       get_pages: "<?php echo base_url('/admin/cms/get_pages') ?>",
       delete_page: "<?php echo base_url('/admin/cms/delete_page') ?>",
       update_page: "<?php echo base_url('/admin/cms/update_page') ?>",
       update_payment: "<?php echo base_url('/admin/settings/update_payment') ?>",
       get_participant: "<?php echo base_url('/admin/participant/get_participant') ?>",
       participant_assign: "<?php echo base_url('/admin/participant/participant_assign') ?>",
       disqulaifyparticipant: "<?php echo base_url('/admin/participant/disqulaifyparticipant') ?>",
       undisqualifyparticipant: "<?php echo base_url('/admin/participant/undisqualifyparticipant') ?>",
       getParticipant: "<?php echo base_url('/admin/participant/getParticipant') ?>",
       update_score: "<?php echo base_url('/admin/participant/update_score') ?>",
       change_status: "<?php echo base_url('/admin/participant/change_status') ?>",
       get_selected_participant: "<?php echo base_url('/admin/participant/get_selected_participant') ?>",
       assign_bulk_reviewer: "<?php echo base_url('/admin/participant/assign_bulk_reviewer') ?>",
       get_transactions: "<?php echo base_url('/admin/payments/get_transactions') ?>",
       get_point_transactions: "<?php echo base_url('/admin/payments/get_point_transactions') ?>",
       delete_account: "<?php echo base_url('delete-account/deleteaccount/delete_account') ?>",
       base_url: "<?php echo base_url(); ?>"
     }
   }
 </script>
 <!-- Custom JS File -->
 <script src="<?= base_url() . JSPATH ?>/page/owl-carousel.js"></script>
 <script src="<?= base_url() . JSPATH ?>/datatable.js"></script>

 <script src="<?= base_url() . JSPATH ?>/page/multiple-upload.js"></script>
 <script src="<?= base_url() . JSPATH ?>/page/advance-table.js"></script>