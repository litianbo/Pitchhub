package 
{
	import flash.utils.Timer;
	import flash.events.TimerEvent;
	import flash.display.Sprite;
	import flash.media.Microphone;
	import flash.system.Security;
	import org.bytearray.micrecorder.*;
	import org.bytearray.micrecorder.events.RecordingEvent;
	import org.bytearray.micrecorder.encoder.WaveEncoder;
	import org.as3wavsound.WavSound;
	import flash.events.MouseEvent;
	import flash.events.Event;
	import flash.events.ActivityEvent;
	import fl.transitions.Tween;
	import fl.transitions.easing.Strong;
	import flash.net.FileReference;
	public class Main extends Sprite
	{
		private var mic:Microphone;//A microphone instance
		private var waveEncoder:WaveEncoder = new WaveEncoder();//Will encode the data captured by the microphone, part of MicRecorder
		private var recorder:MicRecorder = new MicRecorder(waveEncoder);//Creates a MicRecorder instance and uses the WaveEncoder class to encode
		private var recBar:RecBar = new RecBar();//The recording indicator created before
		private var playbackButton:PlaybackButton = new PlaybackButton();//The recording indicator created before
		private var saveButton:SaveButton = new SaveButton();//The recording indicator created before
		private var tween:Tween;//A tween instance, used for animations
		private var fileReference:FileReference = new FileReference();//Used to save the encoded file to disk
		private var isPlaying:Boolean = false;
		private var timer:Timer = new Timer(0);
		public function Main():void
		{
			//Stops the rec button and the mic indicator
			recButton.stop();
			activity.stop();

			//Starts the microphone and shows the Settings dialog to activate it
			mic = Microphone.getMicrophone();
			mic.setSilenceLevel(0);
			mic.gain = 100;
			//mic.setLoopBack(true);
			mic.setUseEchoSuppression(true);
			Security.showSettings("2");

			addListeners();
		}
		private function addListeners():void
		{
			//Starts recording when the rec button is activated
			recButton.addEventListener(MouseEvent.MOUSE_UP, startRecording);
			recorder.addEventListener(RecordingEvent.RECORDING, recording);

			recorder.addEventListener(Event.COMPLETE, recordComplete);
			//The recorder listens for a complete event;
			activity.addEventListener(Event.ENTER_FRAME, updateMeter);
		}
		private function startRecording(e:MouseEvent):void
		{
			if (mic != null)
			{
				recorder.record();
				e.target.gotoAndStop(2);

				recButton.removeEventListener(MouseEvent.MOUSE_UP, startRecording);
				recButton.addEventListener(MouseEvent.MOUSE_UP, stopRecording);

				playbackButton.removeEventListener(MouseEvent.MOUSE_UP, playbackRecording);
				saveButton.removeEventListener(MouseEvent.MOUSE_UP, saveRecording);

				addChild(recBar);

				tween = new Tween(recBar,"y",Strong.easeOut, -  recBar.height,0,1,true);
				tween = new Tween(playbackButton,"x",Strong.easeOut,14,-100,1,true);//Hides the recording bar
				tween = new Tween(saveButton,"x",Strong.easeOut,301,410,1,true);//Hides the recording bar
			}
		}
		private function stopRecording(e:MouseEvent):void
		{
			recorder.stop();
			//Stop recording;

			mic.setLoopBack(false);
			e.target.gotoAndStop(1);
			//Change button icon;

			//Change the listeners to return the buttons original function
			recButton.removeEventListener(MouseEvent.MOUSE_UP, stopRecording);
			recButton.addEventListener(MouseEvent.MOUSE_UP, startRecording);

			tween = new Tween(recBar,"y",Strong.easeOut,0, -  recBar.height,1,true);//Hides the recording bar
		}
		private function updateMeter(e:Event):void
		{
			activity.gotoAndPlay(100 - mic.activityLevel);
		}
		private function recording(e:RecordingEvent):void
		{
			var currentTime:int = Math.floor(e.time / 1000);//Gets the elapsed time since the recording event was called
			//trace(typeof(String(currentTime)));
			var minutes = int(currentTime/60);
			var seconds = currentTime % 60;
			var stringMinutes;
			var stringSeconds;
			//trace(String(minutes) + ":" + String(seconds));
			recBar.counter.text = String(currentTime);//Sets the time to the TextField

			//Formats the text used in the time (2 digits numbers only in this example)
			if (String(minutes).length == 1)
			{
				stringMinutes = "0" + String(minutes);
				//recBar.counter.text = "00:" + String(currentTime);
			}
			else
			{
				stringMinutes = String(minutes);
			}
			if (String(seconds).length == 1)
			{
				stringSeconds = "0" + String(seconds);
				//recBar.counter.text = "00:0" + String(currentTime);
			}
			else
			{
				stringSeconds = String(seconds);
				//recBar.counter.text = "00:" + String(currentTime);
			}
			recBar.counter.text = stringMinutes + ":" + stringSeconds;

		}
		private function recordComplete(e:Event):void
		{
			//this will save the recording

			playbackButton.x = 14;
			playbackButton.y = 126;
			saveButton.x = 301;
			saveButton.y = 126;

			addChild(playbackButton);
			tween = new Tween(playbackButton,"x",Strong.easeOut,-100,14,1,true);
			addChild(saveButton);
			tween = new Tween(saveButton,"x",Strong.easeOut,410,301,1,true);

			playbackButton.addEventListener(MouseEvent.MOUSE_UP, playbackRecording);
			saveButton.addEventListener(MouseEvent.MOUSE_UP, saveRecording);
			//fileReference.save(recorder.output, "recording.wav");

			//this will play the recording;
			//var player:WavSound = new WavSound(recorder.output);
			//player.play();
		}
		private function playbackRecording(e:Event):void
		{
			trace(isPlaying);
			if (! isPlaying)
			{
				isPlaying = true;
				var player:WavSound = new WavSound(recorder.output);
				timer.delay = player.length;
				player.play();
				timer.addEventListener(TimerEvent.TIMER, isFinishedPlaying);
				timer.start();
			}
		}
		private function saveRecording(e:Event):void
		{
			fileReference.save(recorder.output, "recording.wav");
		}
		private function isFinishedPlaying(e:TimerEvent):void
		{
			isPlaying = false;
			timer.removeEventListener(TimerEvent.TIMER, isFinishedPlaying);			
		}
	}
}//Updates the mic activity meter