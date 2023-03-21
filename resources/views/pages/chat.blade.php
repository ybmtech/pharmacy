@extends('layouts.app',['title'=>'Chat'])

@section('content')

<section class="content-header">
    <h1>
        Chat
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Chat</li>
    </ol>
  </section>

  <section class="content">

    <div class="row">

        <div class="col-md-10 col-sm-offset-1">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary">
              <div class="box-header with-border">
             
                <div class="box-tools pull-right">
                   <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fa fa-book"></i></button>
                   </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" style="height:500px;">
                    @forelse ($chats as $chat)
                    @if($chat->sender_id==auth()->user()->id)
                        <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">Me</span>
                        <span class="direct-chat-timestamp pull-right">{{ date('d-m-Y h:i:s a',strtotime($chat->created_at)) }}</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="{{ asset('assets/images/noimage.jpg') }}" alt="Message User Image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        {{ $chat->message }}
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                      @else
                    <!-- Message to the right -->
                    <div class="direct-chat-msg right">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-right">{{ $chat->doctor->name }}</span>
                        <span class="direct-chat-timestamp pull-left">{{ date('d-m-Y h:i:s a',strtotime($chat->created_at)) }}</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="{{ asset('assets/images/noimage.jpg') }}" alt="Message User Image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                          {{ $chat->message }}
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                    @endif
                    @empty
                        
                    @endforelse
                </div>
                <!--/.direct-chat-messages-->
  
                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts">
                  <ul class="contacts-list">
                    @forelse ($doctors as $doctor)

                    <li>
                        <a href="{{ route('patient.chat',$doctor->id) }}">
                          <img class="contacts-list-img" src="{{ asset('assets/images/noimage.jpg') }}" alt="User Image">
    
                          <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                {{ $doctor->name }}
                                 </span>
                          </div>
                          <!-- /.contacts-list-info -->
                        </a>
                      </li>
                      <!-- End Contact Item -->
                        
                    @empty
                        
                    @endforelse
                   
                  </ul>
                  <!-- /.contatcts-list -->
                </div>
                <!-- /.direct-chat-pane -->
              </div>
              <!-- /.box-body -->
              @if(!is_null($id))
              <div class="box-footer">
                <form action="{{ route('patient.chat.save') }}" method="post">
                    @csrf
                  <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                    @error('message')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                    <span class="input-group-btn">
                        <input type="hidden" name="doctor_id" value="{{ $id }}">
                          <button type="submit" class="btn btn-primary btn-flat">Send</button>
                        </span>
                  </div>
                </form>
              </div>
              @endif
              <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
          </div>

    </div>

  </section>

@endsection