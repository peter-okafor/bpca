import ButtonPrimary from "@blog/components/Button/ButtonPrimary";
import { Head } from "@inertiajs/inertia-react";
import React from "react";

interface ErrorPageProps {
    status?: number;
    error?: string;
}

const ErrorPage: React.FC<ErrorPageProps> = ({
    status = 404,
    error = "THE PAGE YOU WERE LOOKING FOR DOESN'T EXIST."
}) => (
  <div className="nc-Page404">
    <Head title="Error" />
    <div className="container relative py-16 lg:py-20">
      {/* HEADER */}
      <header className="text-center max-w-2xl mx-auto space-y-7">
        <h2 className="text-7xl md:text-8xl">🪔</h2>
        <h1 className="text-8xl md:text-9xl font-semibold tracking-widest">
          {status}
        </h1>
        <span className="block text-sm text-neutral-800 sm:text-base dark:text-neutral-200 tracking-wider font-medium">
          {error}.{" "}
        </span>
        <ButtonPrimary href="/" className="mt-4">
          Return Home Page
        </ButtonPrimary>
      </header>
    </div>
  </div>
);

export default ErrorPage;
