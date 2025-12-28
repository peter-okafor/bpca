import React from 'react';

interface ProviderServiceItemProps {
  /**
   * Service logo
   */
  logo: string
  /**
   * Service name
   */
  name: string
}

export const ProviderServiceItem: React.FC<ProviderServiceItemProps> = ({
  logo,
  name,
}) => {
  return (
    <div className="flex flex-row w-full bg-white">
      <div className="basis-1/4 flex flex-col items-center justify-center">
        <img src={logo} alt={name} className="w-16 h-16 rounded-full" />
      </div>
      <div className="basis-3/4 flex flex-col items-left justify-center">
        <p className="text-left text-sm">{name}</p>
      </div>
    </div>
  );
}