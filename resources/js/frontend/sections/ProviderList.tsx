import React from "react";
import { ExpandSearch, Pagination, ProviderCard } from "../components";
import { ProviderInterface } from "../data/ProviderInterface";
import { Inertia } from "@inertiajs/inertia";

interface ProviderListProps {
    providers: ProviderInterface[];
    fallbackLogo: string;

    currentPage?: number;

    pageSize?: number;

    total?: number;

    siblingCount?: number;
}

const makeCall = (phoneNumber: string) => window.open(`tel:${phoneNumber}`, '_self');

export const ProviderList: React.FC<ProviderListProps> = ({
  providers = [],
  fallbackLogo = "",
  currentPage,
  pageSize,
  total,
  siblingCount
}) => {

  const getDetail = (provider: ProviderInterface) => {
    Inertia.visit(`/details/${provider.name}`);
  }

  return (
      <>
          <section
              className="w-full
        rounded-md 
        px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm 
        grid gap-x-6
        lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 grid-cols-1 
        pt-6 pb-6
        min-h-[70px]
        justify-between"
          >
              {!!providers && !!providers.length ? (
                  providers.map((provider, index) => (
                      <div
                          key={index}
                          className="col-span-1 flex flex-col pb-6"
                      >
                          <ProviderCard
                              fallbackLogo={fallbackLogo}
                              key={index}
                              name={provider.name}
                              address={`${provider.address_1}, ${provider.address_2} ${provider.postcode}`}
                              features={provider.features}
                              logo={provider.logo_url}
                              onCall={() => makeCall(provider.telephone)}
                              onShowDetails={() => getDetail(provider)}
                          />
                      </div>
                  ))
              ) : (
                  /** Refactored to
                   * expand search
                   * component */
                  <ExpandSearch className="col-span-4 grid grid-cols-2 my-10 " />
              )}
          </section>
          <div className="flex flex-row items-center justify-center">
              <Pagination
                  currentPage={currentPage ?? 1}
                  totalCount={total ?? 0}
                  onPageChange={(page) => {
                      Inertia.visit(`?page=${page}`);
                  }}
                  pageSize={pageSize ?? 0}
                  siblingCount={siblingCount ?? 1}
              />
          </div>
      </>
  );
}