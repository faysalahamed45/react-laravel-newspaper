import React from 'react';
import { useLocation } from 'react-router-dom';
import { Simplesharer } from 'simple-sharer';
import link from "../../../../public/assets/svgIcon/link.svg";
import {
  EmailShareButton,
  FacebookShareButton,
	FacebookMessengerShareButton,
  LinkedinShareButton,
  TelegramShareButton,
  TwitterShareButton,
  WhatsappShareButton,
} from "react-share";
import {
  EmailIcon,
  FacebookIcon,
  FacebookMessengerIcon,
  LinkedinIcon,
  TelegramIcon,
  TwitterIcon,
  WhatsappIcon,
} from "react-share";

const WebShare = ({toggle,show}) => {
	const sh = new Simplesharer()
	const shareUrl = window.location.href;
  sh.url = window.location.href
	// sh.target = "_blank"
  // sh.title = "Build Brothers Website";


	return (
		<>
		<div className={`weShareApi ${show ? "weShareApiBlock": ""}`}>
			 <div>
			<div className='share text-secondary fw-bold'>
			 <span >শেয়ার</span>
			 </div>
			 <div className='weShareApi-items'>
			  <FacebookShareButton onClick={toggle} url={shareUrl}>
					<div className='d-flex gap-2 align-items-center'>
					 <FacebookIcon size={32} round={true} />
					 <p className='weShareText'>ফেসবুকে শেয়ার করুন</p>
					</div>
         </FacebookShareButton>
			  <FacebookMessengerShareButton onClick={toggle} url={shareUrl}>
					<div className='d-flex gap-2 align-items-center'>
					 <FacebookMessengerIcon size={32} round={true} />
					 <p className='weShareText'>ফেসবুকে শেয়ার করুন</p>
					</div>
         </FacebookMessengerShareButton>
				 <LinkedinShareButton onClick={toggle} url={shareUrl}>
					<div className='d-flex gap-2 align-items-center'>
					 <LinkedinIcon size={32} round={true} />
					 <p className='weShareText'>লিংকডইনে শেয়ার করুন</p>
					</div>
         </LinkedinShareButton>
				 <EmailShareButton onClick={toggle} url={shareUrl} >
					<div className='d-flex gap-2 align-items-center'>
					 <EmailIcon size={32} round={true} />
					 <p className='weShareText'>ইমেইল করুন</p>
					</div>
         </EmailShareButton>
				 <TwitterShareButton onClick={toggle} url={shareUrl}>
					<div className='d-flex gap-2 align-items-center'>
					 <TwitterIcon size={32} round={true} />
					 <p className='weShareText'>টুইটারে শেয়ার করুন</p>
					</div>
         </TwitterShareButton>
				 <div onClick={()=> {sh.copy() ; toggle} } className="d-flex gap-2 align-items-center">
					<div ><img src={link}  /></div>
					<p className='weShareText'>খবরের লিংক কপি করুন</p>
					</div>
				 <WhatsappShareButton url={shareUrl}>
					<div className='d-flex gap-2 align-items-center'>
					 <WhatsappIcon size={32} round={true} />
					 <p className='weShareText'>ওয়াটসঅ্যাপে শেয়ার করুন</p>
					</div>
         </WhatsappShareButton>
				 <TelegramShareButton url={shareUrl}>
					<div className='d-flex gap-2 align-items-center'>
					 <TelegramIcon size={32} round={true} />
					 <p className='weShareText'>টেলিগ্রামে শেয়ার করুন</p>
					</div>
         </TelegramShareButton>

			 </div>
					{/* <div onClick={()=> sh.share('facebook') } className="d-flex">
					<div ><i className="fa-brands fa-facebook"/></div>
					<p>ফেসবুকে শেয়ার করুন</p>
					</div>

					<div onClick={()=> sh.share('linkedin') } className="d-flex">
					<div ><i className="fa-brands fa-facebook"/></div>
					<p>লিংকডইনে শেয়ার করুন</p>
					</div>

					<div onClick={()=> sh.share('email') } className="d-flex">
					<div ><i className="fa-brands fa-facebook"/></div>
					<p>ইমেইল করুন</p>
					</div>

					<div onClick={()=> sh.share('twitter') } className="d-flex">
					<div ><i className="fa-brands fa-facebook"/></div>
					<p>টুইটারে শেয়ার করুন</p>
					</div>

					<div onClick={()=> sh.share() } className="d-flex">
					<div ><i className="fa-brands fa-facebook"/></div>
					<p>খবরের লিংক কপি করুন</p>
					</div>

					<div onClick={()=> sh.share('whatsapp') } className="d-flex">
					<div ><i className="fa-brands fa-facebook"/></div>
					<p>ওয়াটসঅ্যাপে শেয়ার করুন</p>
					</div> */}


					{/* <button onClick={()=> sh.share('twitter') }><i className="fa-brands fa-youtube ps-3 cl-red"/> Share on Twitter</button>
					<button onClick={()=> sh.share('whatsapp') }><i className="fa-brands fa-twitter ps-3"/> Share on Whatsapp</button>
					<button onClick={()=> sh.share('reddit') }><i className="fa-brands fa-instagram ps-3 cl-red"/> Share on Reddit</button>
					<button onClick={()=> sh.copy() }>Copy Link</button> */}
      </div>
		</div>
		</>
	);
};

export default WebShare;