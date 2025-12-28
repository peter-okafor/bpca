import React from 'react';
import { Disclosure } from '@headlessui/react';
import { MenuIcon, XIcon } from '@heroicons/react/outline';
import { NAVIGATION_DEMO } from '../data/navigation';
import { PestLogo } from '../static/PestLogo';
import { Inertia } from '@inertiajs/inertia';

const nav = NAVIGATION_DEMO

const classNames = (...classes:string[]):string => classes.filter(Boolean).join(' ')

export const Header: React.FC = () => {

  const goToHome = () => {
    Inertia.visit('/');
  }
  
  return (
    <Disclosure as="nav" className="bg-white w-full">
      {({ open }) => (
        <>
          <div className="max-w-full mx-auto px-0 lg:px-8">
            <div className="relative flex items-center justify-between h-24">
              <div className="absolute inset-y-0 left-0 flex items-center justify-between w-full">
                <div className="flex-shrink-0 flex items-center hover:cursor-pointer">
                  <PestLogo className="lg:h-10 w-auto h-8" />
                </div>
                <div className="hidden sm:block sm:ml-6">
                  <div className="flex">
                    {nav.map((item, index) => (
                      <a
                        key={item.name}
                        href={item.href}
                        className={classNames(
                         'text-black hover:bg-gray-700 hover:text-white',
                          `px-3 py-2 text-sm font-medium ${nav.length !== index + 1 ? 'border-r' : ''}`
                        )}
                        aria-current={item.current ? 'page' : undefined}
                      >
                        {item.name}
                      </a>
                    ))}
                  </div>
                </div>
              </div>
              <div className="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:hidden">
                {/* Mobile menu button*/}
                <Disclosure.Button className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                  <span className="sr-only">Open main menu</span>
                  {open ? (
                    <XIcon className="block h-6 w-6" aria-hidden="true" />
                  ) : (
                    <MenuIcon className="block h-6 w-6 text-black" aria-hidden="true" />
                  )}
                </Disclosure.Button>
              </div>
            </div>
          </div>

          <Disclosure.Panel className="sm:hidden">
            <div className="px-2 pt-2 pb-3 space-y-1">
              {nav.map((item) => (
                <Disclosure.Button
                  key={item.name}
                  as="a"
                  href={item.href}
                  className={classNames(
                    item.current ? 'bg-gray-900 text-white' : 'text-black hover:bg-gray-700 hover:text-white',
                    'block px-3 py-2 rounded-md text-base font-medium'
                  )}
                  aria-current={item.current ? 'page' : undefined}
                >
                  {item.name}
                </Disclosure.Button>
              ))}
            </div>
          </Disclosure.Panel>
        </>
      )}
    </Disclosure>
  )
}
