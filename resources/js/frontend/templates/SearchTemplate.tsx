import React, { useState } from 'react';
import { PoweredSection, ShowMapButton } from '../components';
import { LinkType } from '../data/models';
import { Footer, Header, Map, Search } from '../sections';

interface SearchTemplateProps {
  showMapButton?: boolean;
  showMap?: boolean;
  setShowMap?: React.Dispatch<React.SetStateAction<boolean>>;
  children: JSX.Element;
  defaultPest?: string;
  defaultPostcode?: string;
  defaultOpen?: boolean;
  footer: LinkType[];
  postCodeError: boolean;
}

export const SearchTemplate = ({
    showMapButton = true,
    showMap,
    setShowMap,
    children,
    defaultPest = "",
    defaultPostcode = "",
    defaultOpen = true,
    footer,
    postCodeError,
}: SearchTemplateProps) => {
    return (
        <>
            <div className="px-4 lg:px-0 md:px-0">
                <Header />
                <div
                    className="
            w-full 
            bg-gradient-to-r from-pest-search-purple to-pest-search-rose 
            lg:rounded-none md:rounded-none rounded-lg 
            px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm 
            sm:py-6 md:py-10 lg:py-10 py-6
            block lg:grid md:grid sm:block
            lg:grid-cols-3 md:grid-cols-3
            gap-x-20"
                >
                    <Search
                        postCodeError={postCodeError}
                        showTitle={false}
                        className={"md:hidden lg:hidden sm:grid grid"}
                    />

                    <Search
                        postCodeError={postCodeError}
                        showTitle={false}
                        horizontal={true}
                        hideLabel={true}
                        defaultPest={defaultPest}
                        defaultPostcode={defaultPostcode}
                        defaultOpen={defaultOpen}
                        className="
                md:grid lg:grid sm:hidden hidden
                col-span-2
                "
                    />
                    {showMapButton && (
                        <ShowMapButton
                            onClick={(e) => {
                                if (setShowMap) {
                                    setShowMap(!showMap);
                                }
                            }}
                            label={showMap ? "Hide Map" : "Show Map"}
                            className="
                    hidden lg:flex md:flex sm:hidden
                    col-span-1
                    border-none"
                        />
                    )}
                </div>
                {children}
            </div>
            <Footer items={footer} />
            <PoweredSection />
        </>
    );
};