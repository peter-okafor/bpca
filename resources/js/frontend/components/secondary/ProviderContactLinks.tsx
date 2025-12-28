import React from 'react';
import { Back } from '../primary/Back';
import { Next } from '../primary/Next';

interface ProviderContactLinksProps {
  onNextClick: () => void,
  onBackClick: () => void
}

export const ProviderContactLinks: React.FC<ProviderContactLinksProps> = ({
  onNextClick,
  onBackClick
}) => {
  return (
    <div className='flex justify-between w-full bg-white rounded-t-md border-gray-300 h-11 align-middle text-center px-4 py-4 border-b'>
      <Back href='#' onClick={onNextClick}/>
      <Next href='#' onClick={onBackClick}/>
    </div>
  );
}