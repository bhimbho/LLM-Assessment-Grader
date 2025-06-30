# Assignment Marking System

A comprehensive web-based application for automated assignment marking and assessment management built with Laravel.

## Overview

This system streamlines the process of marking student assignments by leveraging AI-powered analysis and providing a robust platform for educators to manage assessments, students, and grading workflows.

## Features

### 🎯 **Core Functionality**
- **AI-Powered Marking**: Automated assessment grading using LLM (Large Language Model) integration
- **Student Management**: Comprehensive student database with course and session tracking
- **Question Bank**: Centralized repository for assessment questions and materials
- **File Upload System**: Support for multiple file formats and batch processing
- **Real-time Processing**: Background job processing for efficient assessment handling

### 📊 **Export System**
- **Excel/CSV Exports**: Comprehensive data export functionality
- **Multiple Export Types**: Students, assessments, and combined data exports
- **Automated Filename Sanitization**: Safe file naming across different systems
- **Customizable Formats**: Support for various export configurations

### 🔐 **Security & Access Control**
- **Role-based Authentication**: Admin and user role management
- **Secure File Handling**: Protected file uploads and downloads
- **Session Management**: Robust user session handling

### 📈 **Analytics & Reporting**
- **Assessment Analytics**: Detailed scoring and performance metrics
- **Student Progress Tracking**: Individual and cohort performance analysis
- **Export Capabilities**: Comprehensive data export for external analysis

## Technology Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Database**: MySQL/PostgreSQL with Eloquent ORM
- **AI Integration**: Google Gemini API for automated marking
- **File Processing**: Laravel Excel for data exports
- **Queue System**: Laravel Jobs for background processing
- **Frontend**: Blade templates with Bootstrap styling

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd assignment-marking
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Configure AI service**
   - Add your Gemini API key to `.env`
   - Configure queue settings for background processing

6. **Start the application**
   ```bash
   php artisan serve
   npm run dev
   ```

## Usage

### For Educators
1. **Create Questions**: Add assessment questions to the question bank
2. **Upload Assignments**: Students can upload their assignment files
3. **AI Processing**: System automatically processes and grades assignments
4. **Review Results**: Review AI-generated scores and feedback
5. **Export Data**: Generate reports and export assessment data

### For Administrators
1. **User Management**: Manage educator accounts and permissions
2. **Student Management**: Oversee student database and course assignments
3. **System Monitoring**: Monitor assessment processing and system performance
4. **Data Export**: Generate comprehensive reports and analytics

## Export System

The application includes a robust export system with the following capabilities:

- **StudentsExport**: Basic student information export
- **StudentsWithAssessmentsExport**: Comprehensive student and assessment data
- **AssessmentsExport**: Detailed assessment analytics
- **QuestionAssessmentsExport**: Question-specific assessment results

### Export Formats
- Excel (.xlsx) with automatic styling
- CSV for compatibility
- Custom data filtering and formatting

## API Integration

### Gemini AI Service
- Automated assignment grading
- Intelligent feedback generation
- Configurable marking criteria
- Batch processing capabilities


## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and questions, please contact the development team or create an issue in the repository.
