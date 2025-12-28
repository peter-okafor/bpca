import { GlobeAltIcon, LocationMarkerIcon, MailIcon, PhoneIcon } from '@heroicons/react/solid';
import React from 'react';
import { AccreditationDate, Button, Image, ProviderContactLinks } from '../components';

interface ProviderContactProps {
  logo: string;
  name: string;
  email: string;
  phone: string;
  website: string;
  accreditation_year?: string;
  features?: string[];
  className?: string;
  onNextClick: () => void;
  onBackClick: () => void;

}

const makeCall = (phoneNumber: string) => {
  if (phoneNumber) {
    window.open(`tel:${phoneNumber}`, '_self');
  }
}
const viewWebsite = (url: string) => {
  if (url) {
    window.open(url, '_self');
  }
}
const sendMail = (email: string) => {
  if (email) {
    window.open(`mailto:${email}`, '_self');
  }
}

export const ProviderContact: React.FC<ProviderContactProps> = ({
  logo,
  name,
  email,
  phone,
  website,
  accreditation_year = '',
  features = [],
  className,
  onNextClick,
  onBackClick,
}) => {
  return (
    <div className={`rounded-md bg-white w-full border pb-10 ${className}`}>
      <ProviderContactLinks onNextClick={() => onNextClick()} onBackClick={() => onBackClick()} />
      <div className='flex flex-col justify-center align-middle text-center'>
        <div className='flex flex-row justify-center my-8'>
          <Image className='w-1/2' src={logo} alt='provider logo' fallbackSrc='/images/BPCA-member-logo-400-400.png' />
        </div>
        <h3 className='mb-4 font-bold'>{name}</h3>
      </div>
      <div className='px-2'>
        <Button
          label='Email'
          onClick={() => sendMail(email)}
          style={{
            marginBottom: "1rem"
          }}
          icon={(
            <MailIcon className="h-5 w-5 mr-2 fill-pest-purple mt-0.5"/>
          )}
        />
        <Button
          label='Call'
          onClick={() => makeCall(phone)}
          style={{
            marginBottom: "1rem"
          }}
          icon={(
            <PhoneIcon className="h-5 w-5 mr-2 fill-pest-purple mt-0.5"/>
          )}
        />
        <Button
          label='Website'
          onClick={() => viewWebsite(website)}
          style={{
            marginBottom: "1rem"
          }}
          icon={(
            <GlobeAltIcon className="h-5 w-5 mr-2 fill-pest-purple mt-0.5"/>
          )}
        />
        <Button
          label='Location map'
          style={{
            marginBottom: "1rem"
          }}
          icon={(
            <LocationMarkerIcon className="h-5 w-5 mr-2 fill-pest-purple mt-0.5"/>
          )}
        />
        <AccreditationDate
            accreditation_year={accreditation_year}
        />
        {features && (
                <div className='text-center mb-4'>
                    {features.map((feature, index) => (
                        <p
                            key={index}
                            className='text-[0.65rem] bg-pest-badge-lightpink rounded-xl inline-block m-1 py-1 px-2'
                        >
                            {feature}
                        </p>
                    ))}
                </div>
            )}
      </div>
    </div>
  );
}