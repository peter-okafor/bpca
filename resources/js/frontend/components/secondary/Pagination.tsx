import React from 'react';
import { usePagination, DOTS } from '../../hooks/usePagination';

interface PaginationProps {
  /**
   * Total number of items to display
   */
  totalCount: number
  /**
   * Maximum number of items that is visible in a single page
   */
  pageSize: number
  /**
   * Current page
   */
  currentPage: number
  /**
   * the min number of page buttons to be shown on each side of the current page button
   */
  siblingCount: number,
  /**
   * Page change handler
   */
  onPageChange: (page: number) => void
}

export const Pagination: React.FC<PaginationProps> = ({
  currentPage,
  totalCount,
  pageSize = 5,
  siblingCount = 0,
  onPageChange,
  ...props
}) => {
  const current =  "z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative", 
  normal = "bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative", 
  all="inline-flex items-center px-4 py-2 border text-sm font-medium",
  nearEllipsis=`hidden md:${all}`;

  const paginationRange = usePagination({
    totalCount,
    pageSize,
    siblingCount,
    currentPage
  });

  if (currentPage === 0 || paginationRange.length < 2) {
    return null;
  }
  
  const onNext = () => {
    onPageChange(currentPage + 1);
  };

  const onPrevious = () => {
    onPageChange(currentPage - 1);
  };

  let lastPage = paginationRange[paginationRange.length - 1];
  return (
    <div {...props}>
      <nav className="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
        <a
          href="#"
          className="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
          onClick={onPrevious}
        >
          <span className="sr-only">Previous</span>
          <svg className="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fillRule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clipRule="evenodd" />
          </svg>
        </a>
        {/* Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" */}
        {paginationRange.map((pageNumber, i) => {
          // return pageNumber;
          const isCurrent = pageNumber === currentPage;
          const isNear = Math.abs(parseInt(pageNumber.toString()) - currentPage) <= 2;
          // const isDisabled = pageNumber === 1 || pageNumber === totalCount;
          const className = isCurrent ? current : normal;
          if (pageNumber === DOTS) {
            return <span key={i} className="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"> ... </span>;
          }

          return (
            <a 
              key={i}
              href="#"
              className={`${className} ${all}`}
              onClick={()=>onPageChange(parseInt(pageNumber.toString()))}
            > 
              {pageNumber} 
            </a>
          )
        })}
        <a
          href="#"
          className="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
          onClick={onNext}
        >
          <span className="sr-only">Next</span>
          <svg className="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
          </svg>
        </a>
      </nav>
    </div>
  );
};

export default Pagination;


