@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endsection

@section('content')
<x-page-title title="Pages"></x-page-title>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div style="height: 300px;" id="fm-main-block">
                    <div id="fm"></div>
                </div>
                <pages-index></pages-index>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footerscripts')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    // set fm height
    document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight + 'px');
    const FileBrowserDialogue = {
      init: function() {
        // Here goes your code for setting your custom things onLoad.
      },
      mySubmit: function (URL) {
        // pass selected file path to TinyMCE
        parent.postMessage({
            mceAction: 'insert',
            content: URL,
            text: URL.split('/').pop()
        })
        // close popup window
        parent.postMessage({ mceAction: 'close' });
      }
    };
    // Add callback to file manager
    fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
      FileBrowserDialogue.mySubmit(fileUrl);
    });
  });
</script>
@endsection